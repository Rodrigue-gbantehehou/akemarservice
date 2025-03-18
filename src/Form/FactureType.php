<?php

namespace App\Form;

use App\Entity\Facture;
use App\Entity\commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montatalfacture', NumberType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control-alt'
                ],
            ])

            
            ->add('moyenpaiement', ChoiceType::class, [
                'label' => false,

                'choices'  => [
                    'En espece' => "espece",
                    'MomoPay' => 'MomoPay',
                    'Banacaire' => "Bancaire",
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('TVA', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
