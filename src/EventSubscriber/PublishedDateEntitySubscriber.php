<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.04.2019
 * Time: 16:27
 */

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\AuthoredEntityInterface;
use App\Entity\PublishedDateEntityInterface;
use Faker\Provider\DateTime;
use function in_array;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;



class PublishedDateEntitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setDatePublished', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setDatePublished(GetResponseForControllerResultEvent $event)
    {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!in_array($method, [Request::METHOD_POST, Request::METHOD_PUT]) || !$entity instanceof PublishedDateEntityInterface){
            return;
        }

        $entity->setPublished(new \DateTime());
    }
}