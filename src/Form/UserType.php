<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                ]
                ])
            ->add('password')
            ->add('name')
            ->add('score')
            ->add('picture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
