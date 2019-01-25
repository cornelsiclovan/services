<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.12.2018
 * Time: 12:59
 */

namespace App\Controller;
use App\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        //get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        //get last username enterd by user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
           '_username' => $lastUsername,
        ]);

        return $this->render(
            'security/login.html.twig',
            array(
               'form'  => $form->createView(),
               'error' => $error,
            )
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction(){
        throw \Exception('this should not be reached');
    }
}