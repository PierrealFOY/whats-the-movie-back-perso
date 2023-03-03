<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => 'Recherche:',
                'attr' => [
                    'placeholder' => 'Entrer votre recherche',
                ],
            ]);
        // ->add('synopsis')
        // ->add('releaseDate')
        // ->add('poster')
        // ->add('status')
        // ->add('genres')
        // ->add('actors')
        // ->add('productionStudios')
        // ->add('directors')
        // ->add('countries')
        // ->add('user')
        // ->add('games')
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
