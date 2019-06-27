<?php

namespace App\Form;

use App\Entity\Nomenclature;
use App\Entity\IllustrationType;
use App\Entity\Language;
use App\Entity\Mode;
use App\Entity\PictureSet;
use App\Form\CardType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NomenclatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')            
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
            ])
            ->add('type', EntityType::class, [
                'class' => IllustrationType::class,
                'choice_label' => 'name',
            ])
            ->add('mode', EntityType::class, [
                'class' => Mode::class,
                'choice_label' => 'name',
            ])
            ->add('pictureSet', EntityType::class, [
                'class' => PictureSet::class,
                'choice_label' => 'name',
            ])
            ->add('cards', CollectionType::class, [
                'entry_type' => CardType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Nomenclature'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nomenclature::class,
        ]);
    }
}
