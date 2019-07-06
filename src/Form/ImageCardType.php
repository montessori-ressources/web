<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImageCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      if($options['new']) {
        $builder
            ->add('file', FileType::class)
            //->add('file', HiddenType::class)
        ;
      }
      else {
        $builder
            ->add('file', FileType::class, [
              'is_image' => true,
              'required' => false
            ])
            //->add('file', HiddenType::class)
        ;
      }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'new' => true,
        ]);
    }
}
