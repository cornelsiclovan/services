<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.05.2019
 * Time: 11:11
 */

namespace App\Controller;
use App\Security\UserConfirmationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{


    /**
     * @Route("/confirm-user/{token}", name="default_confirm_token")
     */
    public function confirmUser(string $token, UserConfirmationService $userConfirmationService)
    {
        $userConfirmationService->confirmUser($token);

        return $this->redirectToRoute('app_homepage');
    }
}