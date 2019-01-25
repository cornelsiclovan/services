<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2019
 * Time: 14:39
 */

namespace App\Controller;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceProviderController extends AbstractController
{
    /**
     * @Route("/profile/user/serviceProvider/service/list", name="provider_service_list")
     */
    public function selectService(Request $request, EntityManagerInterface $em){
        $repository = $em->getRepository(Service::class);
        $services = $repository->findAll();

        return $this->render(
            '/prestator/select_service.html.twig',[
                'services' => $services,
            ]
        );
    }

    public function selectSubService(Request $request, EntityManagerInterface $em){

    }
}