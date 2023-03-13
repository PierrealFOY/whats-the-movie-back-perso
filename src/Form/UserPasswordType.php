<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('oldPassword', PasswordType::class, [
            'label' => 'Ancien mot de passe',
            'mapped' => false,
        ])

        ->add('password', RepeatedType::class, [
            "constraints" => [
                new Assert\Regex([
                    'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=[\]{};:\'"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=[\]{};:\'"\\|,.<>\/?]{8,}/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre, un caractère spécial et avoir au moins 8 caractères.'
                ])
            ],
            "type" => PasswordType::class,
            'mapped' => false,
            "invalid_message" => "Les deux mots de passes doivent être identiques",
            "first_options" => [
                "label" => "Le mot de passe",
                "attr" => [
                    "placeholder" => "Le mot de passe"
                ]
            ],
            "second_options" => [
                "label" => "Répétez le mot de passe",
                "attr" => [
                    "placeholder" => "Répétez le mot de passe"
                ]
            ]
                ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
