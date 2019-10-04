<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2019
 * Time: 9:28
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;

class PublishController
{
    public function __invoke(Publisher $publisher): Response
    {
        die();
       return new Response('published to the selected targets');
    }
}