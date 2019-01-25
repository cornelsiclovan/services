<?php
/**
 * Created by PhpStorm.
 * User: Cornel
 * Date: 12/2/2018
 * Time: 1:34 PM
 */

namespace App\Form;


use App\Entity\ServiceProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderRegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('authorizationNumber')
            ->add('name')
            ->add('firstName')
            ->add('email')
            ->add('telephone')
            ->add('country')
            ->add('city')
            ->add('street')
            ->add('number')
            ->add('building')
            ->add('staircase')
            ->add('apartment');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ServiceProvider::class
        ]);
    }
}