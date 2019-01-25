<?php
/**
 * Created by PhpStorm.
 * User: Cornel
 * Date: 11/30/2018
 * Time: 9:13 PM
 */

namespace App\Controller;


use App\Entity\Service;
use App\Entity\SubService;
use App\Form\ServiceRegisterForm;
use App\Form\SubServiceRegisterForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('security_login');
        } else{
            if ($this->isGranted('ROLE_ADMIN'))
                return $this->redirectToRoute('admin_homepage');
            else
                return $this->render(
                    'start/start.html.twig',
                    [
                        'user' => $this->getUser(),
                    ]
                );
        }

    }
    /**
     * @Route("/admin/", name="admin_homepage")
     */
    public function adminHomePage(){
        return $this->render('admin/start.html.twig');
    }

    /**
     * @Route("/admin/register/service", name="service_register")
     */
    public function registerService(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Service::class);
        $services = $repository->findAll();


        $form = $this->createForm(ServiceRegisterForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate adaugata!')
            );

            return $this->redirectToRoute('service_register');
        }
        return $this->render(
            'service/new.html.twig',[
                'registerForm' => $form->createView(),
                'services'=>$services
            ]
        );
    }

    /**
     * @Route("/admin/service/{id}/edit", name="service_edit")
     */
    public function editService(Request $request, EntityManagerInterface $em, Service $service)
    {
        $repository = $em->getRepository(Service::class);
        $services = $repository->findAll();


        $form = $this->createForm(ServiceRegisterForm::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate adaugata!')
            );

            return $this->redirectToRoute('service_register');
        }
        return $this->render(
            'service/edit.html.twig',[
                'registerForm' => $form->createView(),
                'services'=>$services
            ]
        );
    }

    /**
     * @Route("/admin/service/{id}/delete", name="service_delete")
     * @Method("DELETE")
     */
    public function deleteService($id)
    {
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->findOneBy(['id' =>$id]);

        if(!$service){
            throw $this->createNotFoundException('Acest serviciu nu a fost gasit');
        }

        $em->remove($service);
        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/admin/register/sub_service", name="sub_service_register")
     */
    public function registerSubService(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(SubService::class);
        $services = $repository->findAll();


        $form = $this->createForm(SubServiceRegisterForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $subService = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($subService);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate adaugata!')
            );

            return $this->redirectToRoute('sub_service_register');
        }
        return $this->render(
            'subservice/new.html.twig',[
                'subServiceRegisterForm' => $form->createView(),
                'services'=>$services
            ]
        );
    }

    /**
     * @Route("/admin/subservice/{id}/edit", name="sub_service_edit")
     */
    public function editSubService(Request $request, EntityManagerInterface $em, SubService $service)
    {
        $repository = $em->getRepository(SubService::class);
        $services = $repository->findAll();


        $form = $this->createForm(SubServiceRegisterForm::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $subService = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($subService);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Activitate modificata!')
            );

            return $this->redirectToRoute('sub_service_register');
        }
        return $this->render(
            'subservice/edit.html.twig',[
                'subServiceRegisterForm' => $form->createView(),
                'services'=>$services
            ]
        );
    }

    /**
     * @Route("/admin/subserviceservice/{id}/delete", name="sub_service_delete")
     * @Method("DELETE")
     */
    public function deleteSubService($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subService = $em->getRepository(SubService::class)->findOneBy(['id' =>$id]);

        if(!$subService){
            throw $this->createNotFoundException('Acest subserviciu nu a fost gasit');
        }

        $em->remove($subService);
        $em->flush();

        return new Response(null, 204);
    }
}