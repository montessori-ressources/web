<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;


class ImageTypeExtension extends AbstractTypeExtension
{
  /**
  * Return the class of the type being extended.
  */
  public static function getExtendedTypes(): iterable {
    // return FormType::class to modify (nearly) every field in the system
    return [FileType::class];
  }

  public function configureOptions(OptionsResolver $resolver) {
    // makes it legal for FileType fields to have an image_property option
    $resolver->setDefined(['is_image']);
  }

  public function buildView(FormView $view, FormInterface $form, array $options) {
    if (isset($options['is_image'])) {
      // this will be whatever class/entity is bound to your form (e.g. Media)
      $image = $form->getParent()->getData();

      // set image id
      if($image !== null) {
        $view->vars['image_id'] = $image->getId();
      }
      else {
        $view->vars['image_id'] = null;
      }

    }
    else {
      $view->vars['image_id'] = null;
    }
  }
}
