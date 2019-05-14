<?php

namespace App\Email;
use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.05.2019
 * Time: 10:51
 */

class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render(
          'email/confirmation.html.twig',
          [
              'user' => $user
          ]
        );

        $message = (new Swift_Message('Please confirm your account!'))
            ->setFrom('api-platform@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($body,'text/html');

        $this->mailer->send($message);

    }
}