<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordVoter extends Voter
{
    public const PASSWORD_EDIT = 'PASSWORD_EDIT';

    public $security;

    // Permet de récupérer le role du user
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::PASSWORD_EDIT])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $userC, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PASSWORD_EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->editPass($userC, $user);
                break;
        }

        return false;
    }

    public function editPass(User $user)
    {
        return $user === $this->security->getToken()->getUser();
    }
}
