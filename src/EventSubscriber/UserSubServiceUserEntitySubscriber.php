<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.04.2019
 * Time: 16:27
 */

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\Entity\ClientSubService;
use App\Entity\User;
use App\Entity\UserSubService;
use App\Exception\UserAlreadyHasServiceRegisteredException;
use App\Repository\UserSubServiceRepository;
use function array_diff;
use function count;
use function dump;
use function in_array;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function var_dump;

class UserSubServiceUserEntitySubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface  */
    private $tokenStorage;

    /** @var UserSubServiceRepository  */
    private $repo;

    public function __construct(TokenStorageInterface $tokenStorage, UserSubServiceRepository $repo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->repo = $repo;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function getAuthenticatedUser(GetResponseForControllerResultEvent $event)
    {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!in_array($method, [Request::METHOD_POST, Request::METHOD_PUT]) || (!$entity instanceof UserSubService && !$entity instanceof ClientSubService)){
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $entity->setUser($user);
    }
}