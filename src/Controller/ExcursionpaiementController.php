<?php

namespace App\Controller;

use Flasher\Prime\FlasherInterface;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ExcursionpaiementController extends AbstractController
{
    /**
     * @Route("/excursionpaiement", name="app_excursionpaiement")
     */
    public function index(): Response
    {

        return $this->render('excursionpaiement/index.html.twig', [
            'controller_name' => 'ExcursionpaiementController',
        ]);
    }

    /**
     * @Route("/checkoutexcursion", name="checkoutexcursion")
     */
    public function checkoutexcursion($stripeSK): Response
    {
        \Stripe\Stripe::setApiKey($stripeSK);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url',[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return $this->redirect($session->url,303);
    }
    /**
     * @Route("/success_url", name="success_url")
     */
    public function success_url(FlasherInterface $flasher): Response
    {
        $flasher->addSuccess('Ajouté avec succés!');
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
