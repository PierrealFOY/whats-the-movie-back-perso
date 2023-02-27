<?php

namespace App\Form;
Use App\Entity\Director;
use App\Entity\Actor;
use App\Entity\ProductionStudio;
use App\Entity\Country;
use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
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
            ->add('synopsys',TextareaType::class,[
                "label" => "Synopsis",
                "attr" => [
                    "placeholder" => "Synopsis"
                ]
            ])
            ->add('realeaseDate', DateType::class,[
                "label" => "Date de sortie du film",
                "widget" => "single_text"

            ])
          
           ->add('directors',EntityType::class,[
               "class"=> Director::class,
               "label" => "Nom du Réalisateur",
               "multiple"=> true,
                
            ])
              
            ->add('actors',EntityType::class,[
                "class" => Actor::class,
                "label" => "Nom de l'acteur", 
                "multiple"=> true,
                
                ])

            
            ->add('productionStudios',EntityType::class,[
                "class" => ProductionStudio::class,
                "label" => "Nom du Studio",
                "multiple"=> true,
                "attr" => [
                    "placeholder" => "Nom du Studio"
                ]
            ])  
            ->add('countries',EntityType::class,[
                "class" => Country:: class,
                "label" => "Pays de Production",
                "multiple" => true,
                "attr" => [
                    "placeholder" => "Pays"
                ]
            ])


            ->add('poster',UrlType::class,[
                "label" => "Votre image *",
                "attr" => [
                    "placeholder" => "Votre image"
                ],
                "help"=> "* L'url d'une image"
            ])

            ->add('status',ChoiceType::class,[
            "choices" => [
                "actif" => 1 ,
                "inactif" => 0 ,
            ]
           ])

            ->add('genres', EntityType::class,[
                "class" => Genre::class,
                "label" => "Genres *",
                "multiple" => true,
                //"expanded" => true,
                "help" => "* Vous pouvez choisir plusieurs genres"
            ])
           
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
