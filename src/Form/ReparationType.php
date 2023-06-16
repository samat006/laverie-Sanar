<?php

namespace App\Form;

use App\Entity\Reparation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReparationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('statut')
            // ->add('prix')
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy h:mm a',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('commande_id');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reparation::class,
        ]);
    }
}
