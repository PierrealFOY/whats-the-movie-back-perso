<?php

namespace App\Controller\Api;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\CountryRepository;
use App\Repository\DirectorRepository;
use App\Repository\GenreRepository;
use App\Repository\ProductionStudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;


class FormController extends AbstractController
{
    /**
     * method that returns the list of actors, countries, directors, genres, productionStudios
     * @Route("/api/forms", name="app_api_form_list")
     * 
     * @OA\Tag(name="forms")
     * 
     * @param ActorRepository $actorRepository
     * @param CountryRepository $countryRepository
     * @param DirectorRepository $directorRepository
     * @param GenreRepository $genreRepository
     * @param ProductionStudioRepository $productionStudioRepository
     * @return JsonResponse
     */
    public function list(ActorRepository $actorRepository, CountryRepository $countryRepository, DirectorRepository $directorRepository, GenreRepository $genreRepository, ProductionStudioRepository $productionStudioRepository, EntityManagerInterface $em): JsonResponse
    {

        $actors = $actorRepository->findAllForForm();
        
        $countries = $countryRepository->findAllForForm();
        
        $directors = $directorRepository->findAllForForm();

        $genres = $genreRepository->findAllForForm();

        $productionStudios = $productionStudioRepository->findAllForForm();

        return $this->json([
            "actor"             => $actors,
            "countries"         => $countries,
            "directors"         => $directors,
            "genres"            => $genres,
            "productionStudios" => $productionStudios
            ], 
            Response::HTTP_OK, [], ['groups' => 'forms']);
    }
}
