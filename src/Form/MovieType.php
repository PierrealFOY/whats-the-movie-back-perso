<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                "label" => "Titre du film",
                "attr" => [
                    "placeholder" => "Titre du film"
                ]
            ])
            ->add('synopsis',TextareaType::class,[
                "label" => "Synopsis",
                "attr" => [
                    "placeholder" => "Synopsis"
                ]
            ])
            ->add('releaseDate', DateType::class,[
                "label" => "Date de sortie du film",
                "widget" => "single_text"
            ])
            ->add('poster',UrlType::class,[
                "label" => "Votre image *",
                "attr" => [
                    "placeholder" => "Votre image"
                ],
                "help"=> "* L'url d'une image"
            ])
            ->add('status')
            ->add('genres', EntityType::class,[
                "class" => Genre::class,
                "label" => "Genres *",
                "multiple" => true,
                "expanded" => true,
                "help" => "* Vous pouvez choisir plusieurs genres"
            ])
            ->add('actors')
            ->add('productionStudios')
            ->add('directors')
            ->add('countries')
            ->add('user')
            ->add('games')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
