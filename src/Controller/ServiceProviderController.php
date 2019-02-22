<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2019
 * Time: 14:39
 */

namespace App\Controller;

use App\Entity\ClientSubService;
use App\Entity\User;
use App\Entity\UserSubService;
use App\Form\ClientServiceFormType;
use App\Form\CommentFormType;
use App\Form\ProviderSelectServiceType;
use App\Form\SubServiceRegisterForm;
use App\Form\UserRegistrationForm;
use App\Repository\ClientSubServiceRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserSubServiceRepository;
use function array_diff;
use function array_intersect;
use Doctrine\ORM\EntityManagerInterface;
use function dump;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceProviderController extends AbstractController
{
    /**
     * @Route("/profile/user/serviceProvider/service/list", name="provider_service_list")
     */
    public function list(EntityManagerInterface $em){
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
     * @Route("/profile/user/serviceProvider/menu", name="provider_menu")
     */
    public function menu(){
        return $this->render(
            'prestator/menu.html.twig'
        );
    }

    /**
     * @Route("profile/user/serviceProvider/client/requests", name="client_service_request_list")
     */
    public function clientRequests(EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $repository = $em->getRepository(ClientSubService::class);
        $clientSubServices = $repository->findAll();

        $repository = $em->getRepository(UserSubService::class);
        $userSubServices = $repository->findBy(['user'=>$user]);


        $finalClientSubServices = [];
        $finalProviderSubServices = [];

        /***
        foreach ($clientSubServices as $clientSubService) {
            foreach ($clientSubService->getSubServices() as $cSubService) {
                $finalClientSubServices[] = $cSubService;
            }
        }

        foreach($userSubServices as $userSubService){
            foreach($userSubService->getSubServices() as $spSubService){
                $finalProviderSubServices[] = $spSubService;
            }
        }

        if(array_intersect($finalProviderSubServices, $finalClientSubServices) == $finalProviderSubServices){
          //dump(array_intersect($finalClientSubServices, $finalProviderSubServices));
        }

        //dump($finalProviderSubServices);
        //dump($finalClientSubServices);
       // die;
**/

        foreach ($clientSubServices as $clientSubService) {
            foreach ($clientSubService->getSubServices() as $cSubService) {
                foreach($userSubServices as $userSubService){
                    foreach($userSubService->getSubServices() as $spSubService){
                        if($cSubService === $spSubService) {
                            if (!in_array($clientSubService, $finalClientSubServices)) {
                                $finalClientSubServices[] = $clientSubService;
                            }
                        }
                   }
                }
            }
        }


        return $this->render('prestator/client/list.html.twig',
            [
                'clientServices' => $finalClientSubServices,
            ]
        );
    }

    /**
     * @Route("/profile/user/serviceProvider/service/new", name="provider_service_new")
     */
    public function new(Request $request, EntityManagerInterface $em){

        $form = $this->createForm(ProviderSelectServiceType::class);

        //dd($request);

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

    /**
     * @Route("/profile/user/serviceProvider/service/{id}/delete", name="provider_service_delete")
     * @Method("DELETE")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userSubService = $em->getRepository(UserSubService::class)->findOneBy(['id'=>$id]);

        if(!$userSubService){
            throw $this->createNotFoundException('Acest subserviciu nu a fost gasit');
        }

        $em->remove($userSubService);
        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/profile/user/serviceProvider/service/{id}/show", name="provider_service_show")
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $clientSubService = $em->getRepository(ClientSubService::class)->findOneBy(['id'=>$id]);

        $form = $this->createForm(CommentFormType::class);

        return $this->render(
            'prestator/client/detail.html.twig', [
                'clientServiceRequest' => $clientSubService,
                'commentForm' => $form->createView(),
            ]

        );
    }
}