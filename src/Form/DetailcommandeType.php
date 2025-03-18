<?php

namespace App\Form;

use App\Entity\consommable;
use App\Entity\Detailcommande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DetailcommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Impression' => 'impression',
                    'Conception' => 'conception',
                    'Impression et conception' => 'imp_concep'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prix', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dimension', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('consommable', EntityType::class, [
                'label' => false,
                'class' => consommable::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('qteconsommable', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('qtecommande', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('autre', SubmitType::class, [

                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->add('enregister', SubmitType::class, [

                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
