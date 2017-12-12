<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends BaseController
{
    public function index()
    {
        return $this->render('index.html.twig', [
            'greetings' => 'Hola mundo S4'
        ]);
    }
}