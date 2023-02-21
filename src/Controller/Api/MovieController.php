<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\ActorRepository;
use App\Repository\CountryRepository;
use App\Repository\DirectorRepository;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\ProductionStudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MovieController extends AbstractController
{
    /**
     * method that returns the list of movies
     * @Route("/api/movies", name="app_api_movie_list", methods={"GET"})
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
     * method that returns one movie
     * @Route("/api/movies/{id}", name="app_api_movie_show", methods={"GET"})
     * 
     * @param MovieRepository $movieRepository
     * @return JsonResponse
     */
    public function show(MovieRepository $movieRepository, Movie $movie): JsonResponse
    {

        return $this->json($movie, Response::HTTP_OK, [], ['groups' => 'movies']);
    }

    /**
     * method that records a movie 
     * @Route("/api/movies", name="app_api_movie_add", methods={"POST"})
     * 
     * @param MovieRepository $movieRepository
     * @return JsonResponse
     */
    public function add(MovieRepository $movieRepository, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, GenreRepository $genreRepository, ActorRepository $actorRepository, ProductionStudioRepository $productionStudioRepository, DirectorRepository $directorRepository, CountryRepository $countryRepository): JsonResponse
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

        $movieRepository->add($movie, true);

        return $this->json($movie, Response::HTTP_CREATED, [
            'location' => $this->generateUrl("app_api_movie_show", ["id" => $movie->getId()])
        ], 
        ['groups' => 'movies']);
    }



}
