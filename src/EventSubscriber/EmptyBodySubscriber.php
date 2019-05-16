<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.05.2019
 * Time: 11:25
 */

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Exception\EmptyBodyException;
use function in_array;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function var_dump;

class EmptyBodySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['handleEmptyBody', EventPriorities::POST_DESERIALIZE]
        ];
    }

    public function handleEmptyBody(GetResponseEvent $event)
    {
        $method = $event->getRequest()->getMethod();
        if(!in_array($method, [Request::METHOD_POST, Request::METHOD_PUT])){
            return;
        }

        $data = $event->getRequest()->get('data');

        if(null === $data) {
            throw new EmptyBodyException();
        }
    }
}