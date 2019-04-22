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
            //->add('nomenclature')
            ->add('nomenclature', EntityType::class, [
                // looks for choices from this entity
                'class' => Nomenclature::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Upload Cards']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
