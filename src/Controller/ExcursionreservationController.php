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

/**
 * @Route("/excursionreservation")
 */
class ExcursionreservationController extends AbstractController
{
    /**
     * @Route("/", name="excursionreservation_index", methods={"GET"})
     */
    public function index(ExcursionreservationRepository $excursionreservationRepository): Response
    {
        return $this->render('excursionreservation/index.html.twig', [
            'excursionreservations' => $excursionreservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="excursionreservation_new", methods={"GET", "POST"})
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
     * @Route("/{id}", name="excursionreservation_show", methods={"GET"})
     */
    public function show(Excursionreservation $excursionreservation): Response
    {
        return $this->render('excursionreservation/show.html.twig', [
            'excursionreservation' => $excursionreservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="excursionreservation_edit", methods={"GET", "POST"})
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
     * @Route("/{id}", name="excursionreservation_delete", methods={"POST"})
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
}
