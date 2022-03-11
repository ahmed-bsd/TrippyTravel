<?php

namespace App\Controller;

use App\Entity\MaisonReservation;
use App\Form\MaisonReservationType;
use App\Repository\MaisonReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/maison/reservation")
 */
class MaisonReservationController extends AbstractController
{
    /**
     * @Route("/", name="maison_reservation_index", methods={"GET"})
     */
    public function index(MaisonReservationRepository $maisonReservationRepository): Response
    {
        return $this->render('maison_reservation/index.html.twig', [
            'maison_reservations' => $maisonReservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="maison_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maisonReservation = new MaisonReservation();
        $form = $this->createForm(MaisonReservationType::class, $maisonReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maisonReservation);
            $entityManager->flush();

            return $this->redirectToRoute('maison_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maison_reservation/new.html.twig', [
            'maison_reservation' => $maisonReservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maison_reservation_show", methods={"GET"})
     */
    public function show(MaisonReservation $maisonReservation): Response
    {
        return $this->render('maison_reservation/show.html.twig', [
            'maison_reservation' => $maisonReservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="maison_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MaisonReservation $maisonReservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaisonReservationType::class, $maisonReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('maison_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maison_reservation/edit.html.twig', [
            'maison_reservation' => $maisonReservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="maison_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, MaisonReservation $maisonReservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maisonReservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($maisonReservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maison_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
