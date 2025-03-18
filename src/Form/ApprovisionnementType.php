<?php

namespace App\Form;

use App\Entity\Consommable;
use App\Entity\Approvisionnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ApprovisionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Consommable', EntityType::class, [
                'label' => false,
                'class' => Consommable::class,
                'choice_label' => 'nom',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
           
            ->add('quantite',NumberType::class,[
                'label' => false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('montant',NumberType::class,[
                'label' => false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Approvisionnement::class,
        ]);
    }
}
