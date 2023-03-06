<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\AppProvider;
use App\Entity\Actor;
use App\Entity\Country;
use App\Entity\Director;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\ProductionStudio;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");
        $faker->addProvider(new AppProvider());

        $populator = new \Faker\ORM\Doctrine\Populator($faker, $manager);

        // ! Movie

        $populator->addEntity(Movie::class, 20, [
            "title" => function() use ($faker){
                return $faker->unique()->movieTitle();
            },
            "poster" => function () use ($faker) {
                return "https://picsum.photos/id/" . $faker->numberBetween(1, 200) . "/300/500";
            },
            "status" => function () use ($faker) {
                return $faker->randomElement([0, 1]);
            }
        ]);

        // ! Genre

        $populator->addEntity(Genre::class, 20, [
            "name" => function() use ($faker){
                return $faker->unique()->movieGenre();
            }
        ]);

        // ! Actor

        $populator->addEntity(Actor::class, 50);

        // ! Country

        $populator->addEntity(Country::class, 40, [
            "name" => function() use ($faker){
                return $faker->unique()->country();
            }
        ]);

        // ! Director

        $populator->addEntity(Director::class, 20);

        // ! ProductionStudio

        $populator->addEntity(ProductionStudio::class, 20,[
            "name" => function() use ($faker){
                return $faker->unique()->productionStudio();
            }
        ]);

        // ! User

        $users = [];

        $admins = ['jc', 'pa', 'sam'];

        foreach ($admins as $admin) {
            $user = new User();

            $user->setEmail($admin.'@gmail.com');
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setPassword($this->encoder->hashPassword($user, $admin));
            $user->setName($admin);
            $manager->persist($user);
            $users [] = $user;
        }

        for ($i=0; $i < 15 ; $i++) { 
            $user = new User();

            $user->setEmail($faker->email());
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($this->encoder->hashPassword($user, 'user'));
            $user->setName($faker->userName());
            $manager->persist($user);
            $users [] = $user;
        }

        // ! Game

        $populator->addEntity(Game::class, 20, [
            "score" => function() use ($faker){
                return $faker->numberBetween(10, 5000);
            }
        ]);

        // I recover the created objects

        $insertedItems = $populator->execute();

        
        // I recover the movie list and i set one user on movie
        
        $movies = [];
        
        foreach ($insertedItems["App\Entity\Movie"] as $movie) {
            $movie->__construct();
            $movies[] = $movie;
            $randIndex = array_rand($users);
            $movie->setUser($users[$randIndex]);
        }

        // ! Movie_actor

        // for each actor i attribute a movie

        foreach ($insertedItems["App\Entity\Actor"] as $actor) {
            $actor->__construct();
            $actor->addMovie($faker->randomElement($movies));
        }

        // ! Movie_country

        // for each country i attribute a movie

        foreach ($insertedItems["App\Entity\Country"] as $country) {
            $country->__construct();
            $country->addMovie($faker->randomElement($movies));
        }

        // ! Movie_director

        // for each director i attribute a movie

        foreach ($insertedItems["App\Entity\Director"] as $director) {
            $director->__construct();
            $director->addMovie($faker->randomElement($movies));
        }

        // ! Movie_game

        // for each game i attribute 5 movies and 1 user

        foreach ($insertedItems["App\Entity\Game"] as $game) {
            $game->__construct();
            $randomMovieGames = $faker->randomElements($movies, 5);
            foreach ($randomMovieGames as $randomMovieGame) {        
                $game->addMovie($randomMovieGame);
            }
            $randIndex = array_rand($users);
            $game->setUser($users[$randIndex]);
        }

        // ! Movie_production_studio

        // for each production studio i attribute a movie

        foreach ($insertedItems["App\Entity\ProductionStudio"] as $productionStudio) {
            $productionStudio->__construct();
            $productionStudio->addMovie($faker->randomElement($movies));
        }

        // ! Movie_genre

        // for each genre i attribute a movie

        foreach ($insertedItems["App\Entity\Genre"] as $genre) {
            $genre->__construct();
            $genre->addMovie($faker->randomElement($movies));
        }
        
        $manager->flush();
    }
}
