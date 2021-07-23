<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use http\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null,
            [
                'help' => 'What should I call you mate?',
                'attr'=>
                    [
                        'placeholder' => 'e.g. Rick',
                    ]
            ])
            ->add('lastname', null,
                [
                    'attr'=>
                        [
                            'placeholder' => 'e.g. Salvator',
                        ]
                ])
            ->add('username', null,
                [
                    'help' => 'Well to be unique you need your special username, Yeeeey',
                    'attr'=>
                        [
                            'placeholder' => 'e.g. rick_salvator',
                        ]
                ]
            )
            ->add('rawPassword', RepeatedType::class,
            [
                'mapped'=>false,
                'type' => PasswordType::class,

                'invalid_message' => 'Two passwords must match, but they don\'t 😕',
                'first_options'  =>
                    [
                        'label' => 'Password',
                        'help' => 'Enter a password between 8 and 20 characters',
                        'attr'=>
                            [
                                'placeholder' => 'Password',
                            ],
                        'constraints'=>
                            [
                                new NotBlank([
                                    'message'=>'Trust me, you don\'t wanna let it be blank 😉'
                                ]),
                                new Length(
                                    [
                                        'min'=> 8,
                                        'minMessage' => 'Password is shorter than what i expected 😕',
                                        'max'=> 20,
                                        'maxMessage' => 'Password is bigger than what i expected 😕'
                                    ]
                                )
                            ],
                    ],
                'second_options' =>
                    [
                        'help' => 'Enter your password again!',
                        'label' => 'Confirm Password',
                        'constraints'=>
                            [
                                new NotBlank([
                                    'message'=>'Enter again to make sure you want this password🔑'
                                ])
                            ],
                        'attr'=>
                            [
                                'placeholder' => 'Confirm Password',
                            ],

                    ]

            ])

            ->add('email', EmailType::class,
                [
                    'help'=>'We need an email to be in touch you buddy ;)',
                    'attr'=>
                        [
                            'placeholder' => 'e.g. someone@example.com',
                        ]
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
