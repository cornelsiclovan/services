<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.08.2019
 * Time: 15:19
 */

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Email\Mailer;
use App\Entity\PasswordResetTokenEntity;
use App\Repository\UserRepository;
use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PasswordResetTokenEntitySubscriber implements EventSubscriberInterface
{
    private $userRepository;
    private $tokenGenerator;
    /** @var  Mailer */
    private $mailer;

    public function __construct(UserRepository $userRepository, TokenGenerator $tokenGenerator, Mailer $mailer)
    {
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ["addTokenAndUserToEntity", EventPriorities::PRE_VALIDATE]
        ];
    }

    public function addTokenAndUserToEntity(GetResponseForControllerResultEvent $event){

        $passwordResetToken = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$passwordResetToken instanceof PasswordResetTokenEntity || !in_array($method, [Request::METHOD_POST])){
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $passwordResetToken->getEmail()]);

        $passwordResetToken->setToken(
            $this->tokenGenerator->getRandomSecureToken()
        );

        $passwordResetToken->setUser($user);

        $this->mailer->sendForgotPasswordEmail($passwordResetToken, $user);
    }
}