<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid',TextType::class,[
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('poste', ChoiceType::class, [
                'label' => false,

                'choices'  => [
                    'Stagiaire' => "stagiaire",
                    'Secretaire' => 'secretaire',
                    'Technicien' => "technicien",
                    'Graphiste' => "graphiste",
                    'Imprimeur' => "imprimeur",
                    'Directeur Technique' => "Directeur technique",
                    'Chef service' => "chef service",
                    'Intervenant' => "intervenant",
                    

                ],

                'attr' => [
                    'class' => 'form-control'

                ]
            ])
            ->add('telephone',TextType::class,[
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
