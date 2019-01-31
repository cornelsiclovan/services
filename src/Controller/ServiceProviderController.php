<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2019
 * Time: 14:39
 */

namespace App\Controller;

use App\Entity\ServiceProvider;
use App\Entity\User;
use App\Entity\UserSubService;
use App\Form\ProviderSelectServiceType;
use App\Form\SubServiceRegisterForm;
use App\Form\UserRegistrationForm;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceProviderController extends AbstractController
{
    /**
     * @Route("/profile/user/serviceProvider/service/list", name="provider_service_list")
     */
    public function list(Request $request, EntityManagerInterface $em){
        $repository = $em->getRepository(UserSubService::class);
        $user = $this->getUser();
        $userSubServices = $repository->findBy(['user' => $user]);

        return $this->render(
            'prestator/list_service.html.twig', [
                'userSubServices' => $userSubServices,
            ]
        );
    }

    /**
     * @Route("/profile/user/serviceProvider/service/new", name="provider_service_new")
     */
    public function new(Request $request, EntityManagerInterface $em){

        $form = $this->createForm(ProviderSelectServiceType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var  UserSubService|null $userSubService */
            $userSubService = $form->getData();
            $user = $this->getUser();
            $userSubService->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($userSubService);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate adaugata!')
            );

            return $this->redirectToRoute('provider_service_list');
        }

        return $this->render(
            '/prestator/new_service.html.twig',[
                'selectServiceForm' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/profile/user/serviceProvider/service/{id}/edit", name="provider_service_edit")
     */
    public function edit(Request $request, EntityManagerInterface $em, UserSubService $userSubService){

        //dd($userSubService);

        $form = $this->createForm(ProviderSelectServiceType::class, $userSubService);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var  UserSubService|null $userSubService */
            $userSubService = $form->getData();
            $user = $this->getUser();
            $userSubService->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($userSubService);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate modificata!')
            );

            //return $this->redirectToRoute('provider_service_edit');
        }

        return $this->render(
            '/prestator/edit_service.html.twig',[
                'selectServiceForm' => $form->createView(),
            ]
        );
    }


    /**
     * @Route("/profile/user/serviceProvider/service/select", name="sub_service_select")
     */
    public function getSubServiceSelect(Request $request, ServiceRepository $serviceRepository)
    {
        $userSubService = new UserSubService();

        $service = $serviceRepository->findOneBy(['id'=>$request->query->get('service')]);

        $userSubService->setUser($this->getUser());
        $userSubService->setService($service);

        $form = $this->createForm(ProviderSelectServiceType::class, $userSubService);

        if(!$form->has('subService')){
            return new Response(null, 204);
        }

        return $this->render(
            'prestator/_subservice_select.html.twig', [
                'selectServiceForm' => $form->createView(),
            ]
        );
    }
}