<?php

namespace App\Form\Type;

use App\Entity\Wine;
use App\Form\Model\WineDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WineFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('year', TextType::class);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WineDto::class
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