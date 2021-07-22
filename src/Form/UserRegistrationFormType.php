<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null,
            [
                'help' => 'What should I call you mate?',
            ])
            ->add('lastname')
            ->add('username', null,
                [
                    'help' => 'Well to be unique you need your special username, Yeeeey',
                ]
            )
            ->add('rawPassword', PasswordType::class,
            [
                'mapped'=>false,
                'help' => 'Enter a password between 8 and 20 characters',

            ])
            ->add('confirmRawPassword', PasswordType::class,
                [
                    'mapped'=>false,
                    'help' => 'Enter your password again!',

                ])
            ->add('email', EmailType::class,
                [
                    'help'=>'We need an email to be in touch you buddy ;)'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
