<?php

namespace App\Controller;

use App\Entity\ClassifiedCard;
use App\Entity\Nomenclature;
use App\Form\NomenclatureType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class CardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index() {
      $cards = $this->getDoctrine()
        ->getRepository(ClassifiedCard::class)
        ->findAll();

        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'cards' => $cards,
        ]);
    }
    
    /**
     * @Route("/card/upload", name="card_upload")
     */
    public function upload(Request $request) {

        $nomenclature = new Nomenclature();
        $form = $this->createForm(NomenclatureType::Class,$nomenclature);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $nomenclature = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nomenclature);
            $entityManager->flush();

            return $this->render('card/upload-success.html.twig');
        }

        return $this->render('card/upload.html.twig', [
            'formNomenclature' => $form->createView(),
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
