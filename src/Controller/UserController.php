<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/admin-dashboard/users", name="admin-dashboard/users")
     */
    public function admin_index(): Response
    {
        return $this->render('users/admin_index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/trippy/profile", name="profile")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $user->setImageFile(null);      

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('home');
        }

        return $this->render('profile/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin-dashboard/profile", name="profile_admin")
     */
    public function editProfileAdmin(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $user->setImageFile(null);      

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('admin-dashboard');
        }

        return $this->render('profile/editprofileadmin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
