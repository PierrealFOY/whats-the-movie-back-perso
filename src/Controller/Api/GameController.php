<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, GameRepository $gameRepository, UserRepository $userRepository, MovieRepository $movieRepository): JsonResponse
    {
        $json = $request->getContent();

        $game = $serializer->deserialize($json, Game::class, 'json');

        $errors = $validator->validate($game);

        if (count($errors)) {
            $errorsArray = [];

            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json($errorsArray,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // I get my request in a array
        $content = $request->toArray();

        // ! User

        $userId = $content['userId'];
        $game->setUser($userRepository->find($userId));

        // ! Movie

        $idMovies = $content['moviesId'];
        foreach ($idMovies as $idMovie) {
            $game->addMovie($movieRepository->find($idMovie));
        }

        $gameRepository->add($game, true);

        return $this->json($game, Response::HTTP_CREATED, [
            'location' => $this->generateUrl("app_api_movie_show", ["id" => $game->getId()])
        ], 
        ['groups' => 'games']);
    }
}
