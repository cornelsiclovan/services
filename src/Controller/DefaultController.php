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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function time;

class DefaultController extends AbstractController
{


    /**
     * @Route("/confirm-user/{token}", name="default_confirm_token")
     */
    public function confirmUser(string $token, UserConfirmationService $userConfirmationService)
    {
        $userConfirmationService->confirmUser($token);

        //return $this->redirectToRoute('app_homepage');
        return new RedirectResponse("http://localhost:4100/login");
    }

    /**
     * @Route("/recover-account/{token}", name="account_recovery")
     */
    public function recoverAccount(string $token)
    {
        $response = new RedirectResponse("http://localhost:4100/account-recovery");
        $cookie = new Cookie('recoverAccountToken', $token, time() + 60*60, '/', 'localhost', false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }
}