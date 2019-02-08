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
     * @Route("/profile/user/beneficiary/service/new", name="beneficiary_service_new")
     */
    public function new(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(ClientServiceFormType::class);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            /** @var ClientSubService $clientServiceRequest|null */

            $clientServiceRequest = $form->getData();

            dd($clientServiceRequest);
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

}