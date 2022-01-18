<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('age')
            ->add('height')
            ->add('nationality')
            ->add('position')
            ->add('contract_signing_date')
            ->add('contract_end_date')
            ->add('salary')
            ->add('goals')
            ->add('matchsjoues')
            ->add('goals_conceded')
            ->add('photo')
            ->add('firstname')
            ->add('lastname')
            ->add('username');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
