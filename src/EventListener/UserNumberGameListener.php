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

    public function addUserNumberGame(Game $game, LifecycleEventArgs $event)
    {

        $user = $game->getUser();

        $nbGame = $user->getNumberGame();

        $newNumberGame = $nbGame + 1;

        $user->setNumberGame($newNumberGame);
        
        //je flush
        $this->entityManager->flush();
    }
}