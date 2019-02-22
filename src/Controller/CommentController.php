<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.2019
 * Time: 10:56
 */

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     *@Route("/profile/user/comment/new", name="user_comment_new")
     *@Method("POST")
     */
    public function new()
    {

    }
}