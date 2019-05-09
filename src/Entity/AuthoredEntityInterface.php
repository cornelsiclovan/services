<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.05.2019
 * Time: 16:46
 */

namespace App\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthoredEntityInterface
{
    public function setUser(UserInterface $user): AuthoredEntityInterface;
}