<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Nomenclature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('descriptionWithGaps')

            /*
            ->add('nomenclature', EntityType::class, [
                'class' => Nomenclature::class,
                'choice_label' => 'name',
            ])
            */
            //->add('save', SubmitType::class, ['label' => 'Upload Cards']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
