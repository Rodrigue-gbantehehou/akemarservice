<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('uuid', TextType::class, [
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
            ->add('telephone', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'

                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'new-password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
