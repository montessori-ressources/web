<?php
namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DownloadOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('format', ChoiceType::class, [
                'choices'  => [
                    'A4' => 'A4',
                    'US Letter' => 'US',
                ]
            ])
            ->add('nomenclature', HiddenType::class, [])
            ->add('content', ChoiceType::class, [
                'label'    => 'Which content?',
                'choices'  => [
                    'Descrition' => 'desc',
                    'Description with gaps' => 'gaps',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Print PDF'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults([
            'data_class' => Card::class,
        ]);*/
    }
}
