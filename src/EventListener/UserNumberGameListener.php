<?php 

namespace App\EventListener;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserNumberGameListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * method that adds a game to a user when he saves a game
     *
     * @param Game $game
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function addUserNumberGame(Game $game, LifecycleEventArgs $event): void
    {
        $user = $game->getUser();

        $nbGame = $user->getNumberGame();

        $newNumberGame = $nbGame + 1;

        $user->setNumberGame($newNumberGame);
        
        $this->entityManager->flush();
    }
}