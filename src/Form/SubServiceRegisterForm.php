<?php
/**
 * Created by PhpStorm.
 * User: Cornel
 * Date: 12/2/2018
 * Time: 12:52 PM
 */

namespace App\Form;


use App\Entity\Service;
use App\Entity\SubService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubServiceRegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('service', EntityType::class,[
                'class' => Service::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubService::class
        ]);
    }
}