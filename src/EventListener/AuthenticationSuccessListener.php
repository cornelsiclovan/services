<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.05.2019
 * Time: 13:46
 */

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();



        if(!$user instanceof User) {
            return;
        }

        $data['id'] = $user->getId();
        $event->setData($data);
    }
}