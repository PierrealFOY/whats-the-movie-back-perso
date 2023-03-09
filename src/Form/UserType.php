<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => 'Choisis un pseudo',
            ])
            ->add('email', EmailType::class,[
                "label"  => 'Email',
                "attr"   => [
                    "placeholder" => 'Email'
                ]
            ])
            // To edit a password
            ->add('currentPassword', PasswordType::class, [
                // "constraints" => [
                //     new Assert\Regex([
                //         'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                //         "match" => true,
                //         'message' => "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre, un caractère spécial et avoir au moins 8 caractères."
                //     ]),
                // ],
                // first input the current password
                "invalid_message" => "Les deux mots de passes doivent être différents",
                    "label"       => "Le mot de passe actuel",
                    'mapped' => false,
                    "attr"        => [
                        "placeholder" => "Le mot de passe actuel"
                    ]
                ])
                ->add('newPassword', PasswordType::class, [
                    // "constraints" => [
                    //     new Assert\Regex([
                    //         'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    //         "match" => true,
                    //         'message' => "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre, un caractère spécial et avoir au moins 8 caractères."
                    //     ]),
                    // ],
                    // first input the new password
                    "invalid_message" => "Les deux mots de passes doivent être différents",
                        "label"       => "Le nouveau mot de passe",
                        'mapped' => false,
                        "attr"        => [
                            "placeholder" => "Le nouveau mot de passe"
                        ]
                    ])
                    // -> A VOIR DEMAIN !! -> Message erreur sur le Back Office 
                    // Conflit car l'ancien mot de passe ne respecte pas les contraintes de MDP 
                    // Donc pas possible de modifier le mot de passe
            ->add('roles', ChoiceType::class,[
                "choices" => [
                    "Utilisateur" => "ROLE_USER",
                    "Admin"       => "ROLE_ADMIN",
                ],
                "expanded" => true,
                "multiple" => true
            ]);

            if (!$options["edit"]) {
                $builder
                ->add('password', RepeatedType::class, [
                    "constraints" => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                            "match" => true,
                            'message' => "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre, un caractère spécial et avoir au moins 8 caractères."
                        ]),
                    ],
                    "type"            => PasswordType::class,
                    "invalid_message" => "Les deux mots de passes doivent être identiques",
                    "first_options"   => [
                        "label"       => "Le mot de passe",
                        "attr"        => [
                            "placeholder" => "Le mot de passe"
                        ]
                    ],
                    "second_options" => [
                        "label"      => "Répétez le mot de passe",
                        "attr"       => [
                            "placeholder" => "Répétez le mot de passe"
                        ]
                    ]
                        ]);
            }
    }
            

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "edit" => false
        ]);
    }
}
