<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.12.2018
 * Time: 15:47
 */

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
             ->add('serviceProvider')
             ->add('client')
             ->add('name')
             ->add('first_name')
             ->add('email')
             ->add('telephone')
             ->add('country')
             ->add('city')
             ->add('street')
             ->add('number')
             ->add('building')
             ->add('staircase')
             ->add('apartment')
             ->add('plainPassword', RepeatedType::class, [
                 'type' => PasswordType::class
             ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}