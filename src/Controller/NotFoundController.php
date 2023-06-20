<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotFoundController extends AbstractController
{
    public function showNotFound(): Response
    {
        return $this->render('errors/404.html.twig');
    }
}
