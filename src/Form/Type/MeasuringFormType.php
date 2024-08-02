<?php

namespace App\Form\Type;


use App\Form\Model\MeasuringDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MeasuringFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idSensor', TextType::class)
            ->add('idWine', TextType::class)
            ->add('colour', TextType::class)
            ->add('temperature', TextType::class)
            ->add('ph', TextType::class)
            ->add('alcoholContent', TextType::class)
            ->add('year', TextType::class);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MeasuringDto::class
        ]);
    }


    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }
} 