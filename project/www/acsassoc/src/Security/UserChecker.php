<?php
namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
        $role = $user->getRoles()[0];

        if($role == "ROLE_DELETE") {
            throw new CustomUserMessageAuthenticationException("Le compte a été supprimé !");
        }
        if($role == "ROLE_BANNED") {
            throw new CustomUserMessageAuthenticationException("Vous avez été banni !");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}