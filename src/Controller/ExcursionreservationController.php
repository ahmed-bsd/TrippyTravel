<?php

namespace App\Controller;

use App\Entity\Excursionreservation;
use App\Form\ExcursionreservationType;
use App\Repository\ExcursionreservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session;


class ExcursionreservationController extends AbstractController
{
    /**
     * @Route("/excursionreservation/", name="excursionreservation_index", methods={"GET"})
     */
    public function index(ExcursionreservationRepository $excursionreservationRepository): Response
    {
        return $this->render('excursionreservation/index.html.twig', [
            'excursionreservations' => $excursionreservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/excursionreservation/new", name="excursionreservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlasherInterface $flasher): Response
    {
        $excursionreservation = new Excursionreservation();
        $form = $this->createForm(ExcursionreservationType::class, $excursionreservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($excursionreservation);
            $entityManager->flush();
            $flasher->addSuccess('Ajouté avec succés!');
            return $this->redirectToRoute('excursionreservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('excursionreservation/new.html.twig', [
            'excursionreservation' => $excursionreservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/excursionreservation/{id}", name="excursionreservation_show", methods={"GET"})
     */
    public function show(Excursionreservation $excursionreservation): Response
    {
        return $this->render('excursionreservation/show.html.twig', [
            'excursionreservation' => $excursionreservation,
        ]);
    }

    /**
     * @Route("/excursionreservation/{id}/edit", name="excursionreservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Excursionreservation $excursionreservation, EntityManagerInterface $entityManager,FlasherInterface $flasher): Response
    {
        $form = $this->createForm(ExcursionreservationType::class, $excursionreservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flasher->addSuccess('Modifié avec succés!');
            return $this->redirectToRoute('excursionreservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('excursionreservation/edit.html.twig', [
            'excursionreservation' => $excursionreservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/excursionreservation/{id}", name="excursionreservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Excursionreservation $excursionreservation, EntityManagerInterface $entityManager,SweetAlertFactory $flasher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$excursionreservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($excursionreservation);
            $entityManager->flush();
            $flasher->addSuccess('Supprimé avec succès');
        }

        return $this->redirectToRoute('excursionreservation_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/admin-dashboard/excursioncalendar", name="excursion_calendar", methods={"GET"})
     */
    public function calendar(Request $request, ExcursionreservationRepository $repository){
        $events = $repository->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d'),
                'end' => $event->getEnd()->format('Y-m-d'),
                'title' => $event->getStatus(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('excursionreservation/calendar.html.twig', compact('data'));
    }

    /**
     * @Route("/checkoutexcursion", name="checkoutexcursion")
     */
    public function checkoutexcursion($stripeSK,ExcursionreservationRepository $repository): Response
    {
        $session_res  = $this->get("session");
        $reservation_info = $session_res->get("excursionreservation");
        \Stripe\Stripe::setApiKey($stripeSK);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $reservation_info->getExcursion()->getLibelle(),
                    ],
                    'unit_amount' => ($reservation_info->getPrix())*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        $entityManager = $this->getDoctrine()->getManager();
        $payment_intent = ($session->payment_intent);
        $reservation = $repository->find($reservation_info->getId());
        $reservation->setPi($payment_intent);
        $entityManager->flush();

        return $this->redirect($session->url,303);
    }
    /**
     * @Route("/success_url", name="success_url")
     */
    public function success_url($stripeSK,FlasherInterface $flasher,ExcursionreservationRepository $repository): Response
    {
        $session_res  = $this->get("session");
        $reservation_info = $session_res->get("excursionreservation");
        $reservation_detail = $repository->find($reservation_info->getId());
        $pi = $reservation_detail->getPi();
        $stripe = new \Stripe\StripeClient(
            $stripeSK
        );
        $info = $stripe->paymentIntents->retrieve(
            $pi,
            []
        );
        $status = $info->status;
        $entityManager = $this->getDoctrine()->getManager();
        $reservation = $repository->find($reservation_info->getId());
        $reservation->setStatus($status);
        $entityManager->flush();
        $flasher->addSuccess('Paiement effectué avec succés!');
        return $this->render('excursionpaiement/success.html.twig', [
            'controller_name' => 'ExcursionpaiementController',
        ]);
    }
    /**
     * @Route("/cancel_url", name="cancel_url")
     */
    public function cancel_url(): Response
    {
        return $this->render('excursionpaiement/cancel.html.twig', [
            'controller_name' => 'ExcursionpaiementController',
        ]);
    }
}
