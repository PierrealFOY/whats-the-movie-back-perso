<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                "label" => 'Email',
                "attr"   => [
                    "placeholder" => 'Email'
                ]
            ])

            ->add('roles', ChoiceType::class,[
                "choices" => [
                    // on pourrait ajouter aussi un simple user mais le futur utilisateur le fera directement par le biais du formulaire d'inscription
                    "Manager" => "ROLE_MANAGER",
                    "Admin" => "ROLE_ADMIN",
                ],
                "expanded" => true,
                "multiple" => true
            ]);

            if(!$options["edit"]){
                $builder
                ->add('password', RepeatedType::class, [
                    "type" => PasswordType::class,
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
