<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Country;
use App\Entity\Director;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\ProductionStudio;
use App\Entity\User;
use App\Repository\CountryRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("back-office/search", name="app_back_search")
     */
    public function search(Request $request, GenreRepository $genreRepository, CountryRepository $countryRepository ): Response
    {
        $query = $request->query->get('query');
        $genres = $genreRepository->searchByName($request->get("search"));
        $countries = $countryRepository->searchByName($request->get("search"));

        if($countries) {
            return $this->render('back/country/index.html.twig', [
                'countries' => $countries,
            ]);
        }
        elseif($genres) {
            return $this->render('back/genres/index.html.twig', [
                'genres' => $genres,
            ]);
        }
        return $this->render('search/index.html.twig', [
            'query'     => $query,
            'genres'    => $genres,
            'countries' => $countries,
        ]);
    }
}
