<?php

namespace App\Form;

use App\Entity\ClientSubService;
use App\Entity\Service;
use App\Entity\SubService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use function Symfony\Bridge\Twig\Extension\twig_is_selected_choice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cities = ['Timisoara' => 'Timisoara'];

        $builder
            ->add('service', EntityType::class,[
                'placeholder' => 'Alegeti un serviciu',
                'class' => Service::class,
            ])
            ->add('city', ChoiceType::class,[
                'choices' => $cities
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Romania' => 'Romania'
                ]
            ])
        ;

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function(FormEvent $event){
                /** @var ClientSubService|null $data */
                $data = $event->getData();
                if(!$data){
                    return;
                }
                $this->setupSubServicesField(
                    $event->getForm(),
                    $data->getService()
                );
            }
        );

        $builder->get('service')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event){
                $form = $event->getForm();
                $this->setupSubServicesField(
                    $form->getParent(),
                    $form->getData()
                );
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientSubService::class,
        ]);
    }

    private function setupSubServicesField(FormInterface $form, ?Service $service){
        if(null === $service){
            $form->remove('subService');

            return;
        }


        $subServices = $service->getSubServices();
        //dump($subServices);
        if(null === $subServices){
            $form->remove('subService');

            return;
        }



        $form->add('subService', EntityType::class,[
            'class' => SubService::class,
            'choices' => $service->getSubServices(),
            'multiple' => true,
            'expanded' => true,
        ]);

    }
}
