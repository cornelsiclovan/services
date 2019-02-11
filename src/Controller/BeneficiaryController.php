<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.01.2019
 * Time: 13:48
 */

namespace App\Controller;
use App\Entity\ClientSubService;
use App\Entity\Service;
use App\Entity\SubService;
use App\Form\ClientServiceFormType;
use App\Repository\ServiceRepository;
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
        $repository = $em->getRepository(ClientSubService::class);
        $clientServices = $repository->findAll();

        return $this->render('beneficiar/select_service.html.twig',
                [
                    'clientServices' => $clientServices,
                ]
            );
    }

    /**
     * @Route("/profile/user/beneficiary/service/new", name="beneficiary_service_new")
     */
    public function new(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(ClientServiceFormType::class);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            /** @var ClientSubService $clientServiceRequest|null */

            $clientServiceRequest = $form->getData();

            $user = $this->getUser();
            $clientServiceRequest->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($clientServiceRequest);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Solicitare adaugata!')
            );

           return $this->redirectToRoute('beneficiary_service_list');
        }

        return $this->render(
            'beneficiar/service/new.html.twig',[
                'lookForService' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/profile/user/beneficiar/service/select", name="beneficiar_service_select")
     */
    public function getSubServiceSelect(Request $request, ServiceRepository $serviceRepository)
    {
        $clientSubService = new ClientSubService();
        $service = $serviceRepository->findOneBy(['id' => $request->query->get('service')]);


        $clientSubService->setUser($this->getUser());
        $clientSubService->setService($service);



        $form = $this->createForm(ClientServiceFormType::class, $clientSubService);



        if(!$form->has('subService')){
            return new \Symfony\Component\HttpFoundation\Response(null, 204);
        }



        return $this->render(
            'beneficiar/service/_subservice_select.html.twig',[
                'lookForService' => $form->createView(),
            ]
        );
    }

}