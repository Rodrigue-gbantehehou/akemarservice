<?php

namespace App\Form;

use App\Entity\Client;
use App\Form\ClientAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numclient', NumberType::class, [
               
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control-alt'
                ],
            ])
            ->add('description',TextareaType::class,[
                'label' => false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('Prix', NumberType::class, [
               
                'label' => false,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control form-control'
                ],
            ])
            ->add('Typecommande', ChoiceType::class, [
           
                'label' => false,
                'choices'  => [
                    'Impression' => "impression",
                    'Conception' => 'conception',
                    'Impression et Conception' => "impression et conception",
                ],
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'class' => 'form-control'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
