<?php
namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Email\Mailer;
use App\Entity\User;
use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.04.2019
 * Time: 14:02
 */

class UserRegisterSubscriber implements EventSubscriberInterface
{
    /** @var  UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var  TokenGenerator */
    private $tokenGenerator;
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGenerator $tokenGenerator, Mailer $mailer)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
    }

    public function onKernelRequest()
    {
        die('it works');
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ["userRegistered", EventPriorities::PRE_WRITE],
        ];
    }

    public function userRegistered(GetResponseForControllerResultEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$user instanceof User || !in_array($method, [Request::METHOD_POST])){
            return;
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );

        $user->setConfirmationToken(
            $this->tokenGenerator->getRandomSecureToken()
        );

        // Send e-mail here ...

        $this->mailer->sendConfirmationEmail($user);
    }

}