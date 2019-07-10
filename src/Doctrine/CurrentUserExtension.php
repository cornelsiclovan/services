<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.06.2019
 * Time: 11:30
 */

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\ClientSubService;
use App\Entity\ServiceOffer;
use App\Entity\User;
use App\Entity\UserSubService;
use App\Exception\ClientSubServiceNotFound;
use function count;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use function sprintf;
use Symfony\Component\Security\Core\Security;

// Api Platform Extensions
// This class customizes the ClientSubService query for collection and for one item in the sense that it returns also
// the clientSubService for the logged in client

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    private $entityManager;


    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        dump($resourceClass);
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {

       if(!$context['resource_class']==="App\Entity\ServiceOffer")
         $this->addWhere($queryBuilder, $resourceClass);

    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {

        /** @var User $user */
        $user = $this->security->getUser();

        /** @var UserSubService $user_services */
        $user_services = $this->entityManager->getRepository(UserSubService::class)->findBy(["user"=>$user]);
        $ids = [];

        foreach ($user_services as $user_service) {
            $ids[] = $user_service->getService()->getId();
        }

        if(ClientSubService::class !==  $resourceClass || null === $user = $this->security->getUser()  )
        {

            return;
        }


        if(!$this->security->isGranted('ROLE_SERVICE_PROVIDER') && null !== $user){
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
            $queryBuilder->setParameter('current_user', $user);
        }


        if($this->security->isGranted('ROLE_SERVICE_PROVIDER')){
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.service in (:ids)', $rootAlias));
            $queryBuilder->setParameter('ids', $ids);
        }

    }
}