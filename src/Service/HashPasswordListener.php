<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class HashPasswordListener implements EventSubscriberInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUdate(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public static function getSubscribedEvents()
    {
        return['prePersist', 'preUdate'];
    }


    public function encodePassword(User $entity){
        $encoded = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);
    }
}