<?php

namespace App\Controller\Back;

use App\Repository\CountryRepository;
use App\Repository\DirectorRepository;
use App\Repository\GenreRepository;
use App\Repository\ActorRepository;
use App\Repository\MovieRepository;
use App\Repository\ProductionStudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("back-office/resultats", name="app_back_search")
     */
    public function index(Request $request, CountryRepository $countryRepository, GenreRepository $genreRepository, MovieRepository $movieRepository, DirectorRepository $directorRepository, ActorRepository $actorRepository, ProductionStudioRepository $productionStudioRepository  ): Response
    {
        // I will get the value of the search parameter with query method
        $query = $request->query->get("search");
        
        // I stock in variables the result of each entities from each repositories with the respective query builder method
        $countries = $countryRepository->searchByName($query);
        $genres = $genreRepository->searchByName($query);
        $movies = $movieRepository->searchByTitle($query);
        $directors = $directorRepository->searchByName($query);
        $actors = $actorRepository->searchByName($query);
        $productionStudios = $productionStudioRepository->searchByName($query);

        return $this->render('back/results/results.html.twig', [
            'countries' => $countries,
            'genres' => $genres,
            'movies' => $movies,
            'directors' => $directors,
            'actors' => $actors,
            'productionStudios' => $productionStudios,
        ]);
    }
}
