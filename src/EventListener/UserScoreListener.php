<?php 

namespace App\EventListener;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserScoreListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * method that calculates the average score of the player who saves a game
     *
     * @param Game $game
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function calculUserScore(Game $game, LifecycleEventArgs $event): void
    {
        $user = $game->getUser();
        
        $allScores = null;

        foreach ($user->getGames() as $game) {
            $allScores += $game->getScore();
        }

        $score = $allScores / count($user->getGames());

        $user->setScore(round($score));

        $this->entityManager->flush();
    }
}