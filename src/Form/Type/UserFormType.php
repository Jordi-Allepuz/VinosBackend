<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Form\Model\UserDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class ,[
            'required' => false,
            ])
            ->add('lastnames', TextType::class ,[
            'required' => false,
            ])
            ->add('email', TextType::class ,[
            'required' => false,
            ])
            ->add('password', TextType::class ,[
            'required' => false,
            ]);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserDto::class
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