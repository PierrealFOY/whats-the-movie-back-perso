<?php

namespace App\Controller\Back;

use App\Repository\CountryRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("back-office/resultats", name="app_back_search")
     */
    public function index(Request $request, CountryRepository $countryRepository, GenreRepository $genreRepository): Response
    {

        $countries = $countryRepository->searchByName($request->get("search"));
        $genres = $genreRepository->searchByName($request->get("search"));

        return $this->render('back/results/results.html.twig', [
            'countries' => $countries,
            'genres' => $genres,

        ]);
    }
}
