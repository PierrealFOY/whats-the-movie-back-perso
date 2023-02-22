<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * method that returns the list of games
     * @Route("/api/games", name="app_api_game_list", methods={"GET"})
     * 
     * @param GameRepository $gameRepository
     * @return JsonResponse
     */
    public function list(GameRepository $gameRepository): JsonResponse
    {
        $games = $gameRepository->findAll();

        return $this->json($games, Response::HTTP_OK, [], ['groups' => 'games']);
    }

    /**
     * method that returns one game
     * @Route("/api/games/{id}", name="app_api_game_show", methods={"GET"})
     * 
     * @param Game $game
     * @return JsonResponse
     */
    public function show(Game $game): JsonResponse
    {
        return $this->json($game, Response::HTTP_OK, [], ['groups' => 'games']);
    }

    /**
     * method that returns one game
     * @Route("/api/games", name="app_api_game_add", methods={"POST"})
     * 
     * @param Game $game
     * @return JsonResponse
     */
    public function add(): JsonResponse
    {
        return $this->json($game, Response::HTTP_OK, [], ['groups' => 'games']);
    }
}
