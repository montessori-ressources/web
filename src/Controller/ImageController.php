<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Entity\Nomenclature;
use App\Entity\Card;
use App\Entity\Language;
use App\Entity\Mode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/send", name="ajax_image_send")
     * @IsGranted("ROLE_USER")
     */
    public function send(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $image = new Image();
      $media = $request->files->get('file');

      $image->setFile($media);
      $em->persist($image);
      $em->flush();

      return new JsonResponse(array(
        'success' => true,
        'id' => $image->getId()));
    }

    /**
     * @Route("/image/assemble", name="ajax_image_assemble")
     * @IsGranted("ROLE_USER")
     */
    public function create_nomenclature_with_images(Request $request) {
      $em = $this->getDoctrine()->getManager();

      // new nomenclature
      $nomenclature = new Nomenclature();
      $nomenclature->setCreatedBy($this->getUser());

      // do default naming
      $nomenclature->setName("New nomenclature");
      
      $nomenclature->setLanguage(
        $this->getDoctrine()
          ->getRepository(Language::class)
          ->findAll()[0]
        );

        $nomenclature->setMode(
          $this->getDoctrine()
            ->getRepository(Mode::class)
            ->findAll()[0]
          );


      // for each image sent by the ajax query
      foreach ($request->query->get('images') as $id) {

        // create a card
        $card = new Card();

        $card->setLanguage(
          $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAll()[0]
          );

        $card->setLabel("New card");

        // get the image
        $image = $this->getDoctrine()
          ->getRepository(Image::class)
          ->findOneById($id);

        $card->setImage($image);
        $nomenclature->addCard($card);
      }

      $em->persist($nomenclature);
      $em->flush();

      return new JsonResponse(array(
        'nomenclature' => $nomenclature->getId()
      ));

    }
}
