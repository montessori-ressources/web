<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LocaleController extends AbstractController
{

    /**
     * @Route("/locale/{locale}", name="locale_switch")
     */
    public function switchlanguageAction(Request $request, $locale) {
      $request->attributes->set('_locale', null);
      $this->get('session')->set('_locale', $locale);
      return $this->redirect($this->generateUrl('home'));
   }
}
