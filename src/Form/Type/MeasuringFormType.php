<?php

namespace App\Form\Type;


use App\Form\Model\MeasuringDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MeasuringFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idSensor', IntegerType::class)
            ->add('idWine', IntegerType::class)
            ->add('colour', TextType::class)
            ->add('temperature', IntegerType::class)
            ->add('ph', IntegerType::class)
            ->add('alcoholContent', IntegerType::class)
            ->add('year', IntegerType::class);

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