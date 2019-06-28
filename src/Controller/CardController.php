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
use Symfony\Component\HttpFoundation\JsonResponse;
use League\Flysystem\Filesystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class CardController extends AbstractController
{
    /**
     * @Route("/card/", name="card_index")
     */
    public function index() {

        return $this->render('card/index.html.twig', [
        ]);
    }

    /**
     * @Route("/nomenclature/upload", name="nomenclature_upload")
     * @IsGranted("ROLE_USER")
     */
    public function uploadNomenclature(Request $request) {
        $nomenclature = new Nomenclature();
        $card = new Card();
        $nomenclature->addCard($card);
        $form = $this->createForm(NomenclatureType::Class,$nomenclature);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomenclature = $form->getData();

            // assign the nomenclature to the current user
            $currentUser= $this->getUser();
            $nomenclature->setCreatedBy($currentUser);

            // set card language with the same language as the nomenclature
            $nomLang = $nomenclature->getLanguage(); 
            foreach ($nomenclature->getCards() as $card){
                $card->setLanguage($nomLang);
            }

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
     * @IsGranted("ROLE_USER")
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
     * @Route("/card/{id}/download", name="card_download")
     * @IsGranted("ROLE_USER")
     */
    public function download(Nomenclature $nomenclature) {
      $html = $this->renderView('card/print.html.twig', [
          'nomenclature' => $nomenclature,
      ]);

      $pdfOptions = new Options();
      $pdfOptions->set('isRemoteEnabled', true);
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
      $response = new Response($filesystem->read($image->getName()));
      $response->headers->set('Content-Type', $filesystem->getMimetype($image->getName()));
      return $response;
    }

    /**
     * @Route("/card/search", name="card_search")
     * Search
     */
    public function search(Request $request) {
      $requestString = $request->get('q');
      $entities =  $this->getDoctrine()->getRepository(Nomenclature::class)->search($requestString);

      if(!$entities) {
          $result['entities']['error'] = "No result";
      } else {
        foreach ($entities as $entity){
          $result['entities'][$entity->getId()] = $entity->getName();
        }
      }
      return new JsonResponse($result);
    }

    /**
     * @Route("/nomenclature", name="nomenclature_show", defaults={"id"=0})
     * Search
     */
    public function show(String $id, Request $request) {
      if($id == 0) {
        $id = $request->get('q');
      }
      $nomenclature = $this->getDoctrine()->getRepository(Nomenclature::class)->findOneById($id);
      return $this->render('card/show.html.twig', [
          'nomenclature' => $nomenclature,
      ]);
    }
}
