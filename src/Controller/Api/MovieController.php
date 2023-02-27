<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\ActorRepository;
use App\Repository\CountryRepository;
use App\Repository\DirectorRepository;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\ProductionStudioRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use  Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

class MovieController extends AbstractController
{
    /**
     * method that returns the list of movies
     * 
     * @OA\Tag(name="movies")
     * 
     * @Route("/api/movies", name="app_api_movie_list", methods={"GET"})
     * @isGranted("ROLE_ADMIN", message="Vous devez être un administrateur")
     * 
     * @param MovieRepository $movieRepository
     * @return JsonResponse
     */
    public function list(MovieRepository $movieRepository): JsonResponse
    {
        $movies = $movieRepository->findAll();

        return $this->json($movies, Response::HTTP_OK, [], ['groups' => 'movies']);
    }

    /**
     * method that returns number(limit) of movies for one game
     * 
     * @OA\Parameter(
     *      name="limit",
     *      in="query",
     *      description="Le nombre de films que l'on veut récupérer",
     *      @OA\Schema(type="int")
     * )
     * @OA\Tag(name="movies")
     * 
     * @Route("/api/movies/games", name="app_api_movie_randomMoviesGame", methods={"GET"})
     * @isGranted("ROLE_ADMIN", message="Vous devez être un administrateur")
     * 
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function randomMoviesGame(MovieRepository $movieRepository, Request $request): JsonResponse
    {
        $limit = (int)$request->get('limit', 5);

        $moviesGame = $movieRepository->findRandomMoviesGame($limit);

        return $this->json($moviesGame, Response::HTTP_OK, [], ['groups' => 'movies']);
    }

    /**
     * method that returns one movie
     * 
     * @OA\Tag(name="movies")
     * 
     * @Route("/api/movies/{id}", name="app_api_movie_show", methods={"GET"})
     * @isGranted("ROLE_ADMIN", message="Vous devez être un administrateur")
     * 
     * @param MovieRepository $movieRepository
     * @param int $id
     * @return JsonResponse
     */
    public function show(MovieRepository $movieRepository, int $id): JsonResponse
    {
        $movie = $movieRepository->find($id);

        return $this->json($movie, Response::HTTP_OK, [], ['groups' => 'movies']);
    }

    /**
     * method that records a movie 
     * 
     * @OA\Tag(name="movies")
     * 
     * @Route("/api/movies", name="app_api_movie_add", methods={"POST"})
     * 
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param GenreRepository $genreRepository
     * @param ActorRepository $actorRepository
     * @param ProductionStudioRepository $productionStudioRepository
     * @param DirectorRepository $directorRepository
     * @param CountryRepository $countryRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function add(MovieRepository $movieRepository, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, GenreRepository $genreRepository, ActorRepository $actorRepository, ProductionStudioRepository $productionStudioRepository, DirectorRepository $directorRepository, CountryRepository $countryRepository, UserRepository $userRepository): JsonResponse
    {
        $json = $request->getContent();

        $movie = $serializer->deserialize($json, Movie::class, 'json');

        $errors = $validator->validate($movie);

        if (count($errors)) {
            $errorsArray = [];

            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json($errorsArray,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // I get my request in a array
        $content = $request->toArray();

        // ! Genres
        // I get id(s) genre in a array
        $idGenres = $content['idGenres'];

        //for each id i add genre to movie
        foreach ($idGenres as $idGenre) {
            $movie->addGenre($genreRepository->find($idGenre));
        }

        // ! Actors
        $idActors = $content['idActors'];
        foreach ($idActors as $idActor) {
            $movie->addActor($actorRepository->find($idActor));
        }

        // ! ProductionStudios
        $idProductionStudios = $content['idProductionStudios'];
        foreach ($idProductionStudios as $idProductionStudio) {
            $movie->addProductionStudio($productionStudioRepository->find($idProductionStudio));
        }

        // ! Directors
        $idDirectors = $content['idDirectors'];
        foreach ($idDirectors as $idDirector) {
            $movie->addDirector($directorRepository->find($idDirector));
        }

        // ! Countries
        $idCountries = $content['idCountries'];
        foreach ($idCountries as $idCountry) {
            $movie->addCountry($countryRepository->find($idCountry));
        }

        // ! User TODO
        $movie->setUser($userRepository->find(291));

        $movieRepository->add($movie, true);

        return $this->json($movie, Response::HTTP_CREATED, [
            'location' => $this->generateUrl("app_api_movie_show", ["id" => $movie->getId()])
        ], 
        ['groups' => 'movies']);
    }



}
