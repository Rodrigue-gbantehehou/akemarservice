<?php

namespace App\Form;

use App\Entity\Consommable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ImpConcepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomimpression',TextType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
       
        ->add('consommable',EntityType::class,[
            'label' => false,
            'class' => Consommable::class,
            
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ->add('nombrepapier',NumberType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ->add('xdimension',NumberType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ->add('ydimension',NumberType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ->add('typeconception',TextareaType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ->add('dureconception',DateType::class,[
            'label' => false,
            'attr'=>[
                'class'=>'form-control form-control-alt'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
