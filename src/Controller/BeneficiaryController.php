<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.01.2019
 * Time: 13:48
 */

namespace App\Controller;
use App\Entity\Service;
use App\Entity\SubService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiaryController extends AbstractController
{
    /**
     * @Route("/profile/user/beneficiary/service/list/", name="beneficiary_service_list")
     */
    public function selectService(Request $request, EntityManagerInterface $em){
        $repository = $em->getRepository(Service::class);
        $services = $repository->findAll();

        return $this->render('beneficiar/select_service.html.twig',
                [
                    'services' => $services,
                ]
            );
    }

    /**
     * @Route("/profile/user/beneficiary/subservice/list/{id}", name="beneficiary_subservice_list")
     */
    public function selectSubService(Request $request, EntityManagerInterface $em, Service $service){
        $repository = $em->getRepository(SubService::class);
        $subServices = $repository->findBy(['service' => $service]);

        return $this->render('beneficiar/subservice/select.html.twig',
            [
                'subServices' => $subServices,
            ]);
    }
}