<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Nomenclature;
use App\Form\CardType;
use App\Form\NomenclatureType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use League\Flysystem\Filesystem;
use Core23\DompdfBundle\Wrapper\DompdfWrapper;
use TFox\MpdfPortBundle\Response\PDFResponse;
use TFox\MpdfPortBundle\Service\PDFService;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class CardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index() {
      $nomenclatures = $this->getDoctrine()
        ->getRepository(Nomenclature::class)
        ->findAll();

        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'nomenclatures' => $nomenclatures,
        ]);
    }

    /**
     * @Route("/nomenclature/upload", name="nomenclature_upload")
     */
    public function uploadNomenclature(Request $request) {
        $nomenclature = new Nomenclature();
        $card = new Card();
        $nomenclature->addCard($card);
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
     * @Route("/card/upload", name="card_upload")
     */
    public function uploadCard(Request $request) {
        $card = new Card();
        $form = $this->createForm(CardType::Class,$card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($card);
            $entityManager->flush();
            return $this->render('card/upload-success.html.twig');
        }

        return $this->render('card/upload.html.twig', [
            'formNomenclature' => $form->createView(),
        ]);
    }

    /**
     * @Route("/card/{id}/download2", name="card_download2")
     */
    public function download2(Nomenclature $nomenclature) {
      return $this->render('card/print.html.twig', [
          'nomenclature' => $nomenclature,
      ]);
    }

    /**
     * @Route("/card/{id}/download", name="card_download")
     */
    public function download(Nomenclature $nomenclature, PDFService $service) {
      $html = $this->renderView('card/print.html.twig', [
          'nomenclature' => $nomenclature,
      ]);
      // try{
      //   return new PDFResponse($service->generatePdf($html));
      // } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
      //   // Process the exception, log, print etc.
      //   echo $e->getMessage();
      //   return new Response("error " . $e->getMessage());
      // }


      // $response = $pdf->getStreamResponse($html, "card.pdf",
      // ["Attachment" => false]);
      // $response->send();

      $pdfOptions = new Options();
      //$pdfOptions->set('isRemoteEnabled', true);
      //
      // Instantiate Dompdf with our options
      $dompdf = new Dompdf($pdfOptions);

      // Load HTML to Dompdf
      $dompdf->loadHtml($html);

      // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
      $dompdf->setPaper('A4', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();
      //
      // Output the generated PDF to Browser (inline view)
      $dompdf->stream("card.pdf", [
          "Attachment" => false
      ]);
    }

    /**
     * @Route("/card/image/{id}", name="image")
     */
    public function image(Image $image, Filesystem $filesystem) {
      //$this->get('oneup_flysystem.image_adapter');
      $response = new Response($filesystem->read($image->getName()));
      $response->headers->set('Content-Type', $filesystem->getMimetype($image->getName()));
      return $response;
    }

    /**
     * @Route("/card/image2/{id}", name="image2")
     */
    public function image2(Image $image, Filesystem $filesystem) {
      $response = new Response($filesystem->read($image->getName()));
      $response->headers->set('Content-Type', $filesystem->getMimetype($image->getName()));
      return $response;
    }
}
