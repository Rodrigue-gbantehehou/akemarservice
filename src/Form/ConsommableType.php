<?php

namespace App\Form;

use App\Entity\Consommable;
use App\Entity\commandeimpression;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConsommableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
            ->add('typeduconsommable', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
            ->add('typepapier', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
            ->add('formatsupport', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
            ->add('prixunit', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
            ->add('qtedispo', TextType::class, [
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control form-control-alt'
                ],
            ])
     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consommable::class,
        ]);
    }
}
