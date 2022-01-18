<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'firstname'])
            ->add('lastname')
            ->add('email')
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => "The age cannot be negative."
                    ]),
                ]
            ])
            ->add('username')
            ->add('matchsjoues')
            ->add('height')
            ->add('nationality')
            ->add('position')
            ->add('contract_signing_date')
            ->add('contract_end_date')
            ->add('salary', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => "a salary cannot be negative."
                    ]),
                ]
            ])
            ->add('goals', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => -1,
                        'message' => "the number of goals cannot be negative."
                    ]),
                ]
            ])
            ->add('goals_conceded', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => -1,
                        'message' => "the number of conceded goals cannot be negative."
                    ]),
                ]
            ])->add('photo')

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least 8 characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
