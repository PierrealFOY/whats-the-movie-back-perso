<?php

namespace App\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class UserVoter extends Voter
{
    const PASSWORD_EDIT = 'password_edit';
    const VIEW = 'view';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::PASSWORD_EDIT, self::VIEW])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute ($attribute, $subject, TokenInterface $token): bool
    {

    $user = $token->getUser();

    // if the user is anonymous, do not grant access
    if (!$user instanceof UserInterface) {
        return false;
    }

    if ($this->security->isGranted('ROLE_CONNECTED_USER')) {
        return true;
    }

    // ... (check conditions and return true to grant permission) ...
    switch ($attribute) {
        case self::PASSWORD_EDIT:
            // logic to determine if the user can EDIT
            // return true or false
            break;
        case self::VIEW:
            // logic to determine if the user can VIEW
            // return true or false
            break;
    }

    return $subject->getId() === $user->getUserIdentifier();
}

}
