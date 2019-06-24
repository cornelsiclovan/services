<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.06.2019
 * Time: 15:14
 */

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ClientSubService;
use App\Entity\ServiceOffer;
use App\Entity\User;
use App\Exception\ClientSubServiceNotFound;
use App\Exception\ClientSubServiceNotFoundException;
use function in_array;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ServiceOfferManager implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {

        return [
            KernelEvents::VIEW => ['checkClientServiceAvailability', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function checkClientServiceAvailability(GetResponseForControllerResultEvent $event): void
    {
        /** @var ServiceOffer $serviceOffer */
        $serviceOffer = $event->getControllerResult();

        if(!$serviceOffer instanceof ServiceOffer || $event->getRequest()->isMethodSafe(false)) {
            return;
        }

        /** @var User $user */
        $user = $serviceOffer->getAuthor();

        $userServices = $user->getUserSubServices();
        $serviceIds = [];

        foreach($userServices as $userService) {
            $serviceIds[] = $userService->getService()->getId();
        }


        /** @var ClientSubService $clientSubService */
        $clientSubService = $serviceOffer->getClientSubService();

        $clientServiceId = $clientSubService->getService()->getId();

        if(!in_array($clientServiceId, $serviceIds)){
            throw new ClientSubServiceNotFoundException();
        }


        if(in_array($serviceOffer->getClientSubService(),[] )) {
            throw new ClientSubServiceNotFound();
        }
    }
}