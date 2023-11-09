<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datetime', DateType::class, [
                'widget' => 'choice',
            ])
            ->add('temperature', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Enter temperature in celsius'
                ],
                'required' => false,
            ])
            ->add('wind_speed', NumberType::class, [
                'html5' => true,
                'required' => false,
            ])
            ->add('wind_direction', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter wind direction'
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
