<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DompdfController extends AbstractController
{
//    /**
//     * @Route("/dompdf", name="app_dompdf")
//     */
//    public function index(): Response
//    {
//        return $this->render('dompdf/index.html.twig', [
//            'controller_name' => 'DompdfController',
//        ]);
//    }
//Generate and force PDF File download
    public function generate_download()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('excursionpdf/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    public function generate_view($excursionreservation)
    {
        $reservation_id = $excursionreservation->getId();
        $client = $excursionreservation->getUser();
        $client_firstname = $client->getFirstname();
        $client_lastname = $client->getLastname();
        $client_email = $client->getEmail();
        $reservation_lib = $excursionreservation->getExcursion()->getLibelle();
        $reservation_prix = $excursionreservation->getExcursion()->getPrix()." DT";
        $reservation_description = $excursionreservation->getExcursion()->getDescription();
        $reservation_prog = $excursionreservation->getExcursion()->getProgramme();
        $path = 'logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $date = date('d/m/Y');
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('excursionpdf/mypdf.html.twig', [
            'ID' => $reservation_id,
            'title' => "Réservation excursion ($reservation_id)",
            'logo' => $base64,
            'date' => $date,
            'client_firstname' => $client_firstname,
            'client_lastname' => $client_lastname,
            'client_email' => $client_email,
            'reservation_lib' => $reservation_lib,
            'reservation_prix' => $reservation_prix,
            'reservation_description' => $reservation_description,
            'reservation_prog' => $reservation_prog,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

    public function generate_store()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('excursionpdf/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->get('kernel')->getProjectDir() . '/public';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/mypdf.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }
}
