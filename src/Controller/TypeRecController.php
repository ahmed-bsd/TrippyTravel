<?php

namespace App\Controller;

use App\Entity\TypeRec;
use App\Form\TypeRecType;
use App\Repository\TypeRecRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin-dashboard/type/rec")
 */
class TypeRecController extends AbstractController
{
    /**
     * @Route("/", name="type_rec_index", methods={"GET"})
     */
    public function index(TypeRecRepository $typeRecRepository): Response
    {
        return $this->render('type_rec/index.html.twig', [
            'type_recs' => $typeRecRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_rec_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeRec = new TypeRec();
        $form = $this->createForm(TypeRecType::class, $typeRec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeRec);
            $entityManager->flush();

            return $this->redirectToRoute('type_rec_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_rec/new.html.twig', [
            'type_rec' => $typeRec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_rec_show", methods={"GET"})
     */
    public function show(TypeRec $typeRec): Response
    {
        return $this->render('type_rec/show.html.twig', [
            'type_rec' => $typeRec,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_rec_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeRec $typeRec, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeRecType::class, $typeRec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_rec_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_rec/edit.html.twig', [
            'type_rec' => $typeRec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_rec_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeRec $typeRec, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeRec->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeRec);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_rec_index', [], Response::HTTP_SEE_OTHER);
    }
}
