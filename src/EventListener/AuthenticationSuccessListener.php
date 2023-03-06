<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    /**
     * Methode for return user info with the token when connecting
     *
     * @param AuthenticationSuccessEvent $event
     * @return void
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['data'] = array(
            'id' => $user->getId(),
            'role' => $user->getRoles(),
            'name' => $user->getName(),
            'picture' => $user->getPicture(),
            'score' => $user->getScore(),
            'numberGame' => $user-> getNumberGame(),
            );

        $event->setData($data);
    }
}