<?php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datedebut', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy h:mm a',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('datefin', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy h:mm a',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('type')
            ->add('statut')
            // ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
