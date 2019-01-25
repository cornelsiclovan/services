<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.12.2018
 * Time: 14:15
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('_username')
               ->add('_password', PasswordType::class);
    }
}