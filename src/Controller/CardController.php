<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ClassifiedCard;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class CardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
      $cards = $this->getDoctrine()
        ->getRepository(ClassifiedCard::class)
        ->findAll();

        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'cards' => $cards,
        ]);
    }

    /**
     * @Route("/card/{id}/download", name="card_download")
     */
    public function download(ClassifiedCard $card) {
      $html = $this->renderView('card/print.html.twig', [
          'card' => $card,
      ]);


      $pdfOptions = new Options();

      // Instantiate Dompdf with our options
      $dompdf = new Dompdf($pdfOptions);

      // Load HTML to Dompdf
      $dompdf->loadHtml($html);

      // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
      $dompdf->setPaper('A4', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      // Output the generated PDF to Browser (inline view)
      $dompdf->stream("card.pdf", [
          "Attachment" => false
      ]);
    }
}
