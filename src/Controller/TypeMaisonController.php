<?php

namespace App\Controller;

use App\Entity\TypeMaison;
use App\Form\TypeMaisonType;
use App\Repository\MaisonshotesRepository;
use App\Repository\TypeMaisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class TypeMaisonController extends AbstractController
{
    /**
     * @Route("/", name="type_maison_index", methods={"GET"})
     */
    public function index(TypeMaisonRepository $typeMaisonRepository): Response
    {
        return $this->render('type_maison/index.html.twig', [
            'type_maisons' => $typeMaisonRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin-dashboard/type_maisons", name="type_maison_index_admin")
     */
    public function admin_index(TypeMaisonRepository $typeMaisonRepository): Response

    {
        return $this->render('type_maison/index.html.twig', [
            'type_maisons' => $typeMaisonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/type_maisons/new", name="type_maison_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeMaison = new TypeMaison();
        $form = $this->createForm(TypeMaisonType::class, $typeMaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeMaison);
            $entityManager->flush();

            return $this->redirectToRoute('type_maison_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_maison/new.html.twig', [
            'type_maison' => $typeMaison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/type_maisons/{id}/show", name="type_maison_show", methods={"GET"})
     */
    public function show(TypeMaison $typeMaison): Response
    {
        return $this->render('type_maison/show.html.twig', [
            'type_maison' => $typeMaison,
        ]);
    }

    /**
     * @Route("/admin-dashboard/type_maisons/{id}/edit", name="type_maison_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeMaison $typeMaison, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeMaisonType::class, $typeMaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_maison_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_maison/edit.html.twig', [
            'type_maison' => $typeMaison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/type_maisons/{id}", name="type_maison_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeMaison $typeMaison, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeMaison->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeMaison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_maison_index_admin', [], Response::HTTP_SEE_OTHER);
    }
}
