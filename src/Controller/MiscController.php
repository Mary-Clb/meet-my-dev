<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MiscController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('misc/about.html.twig');
    }

    #[Route('/error', name: 'app_err')]
    public function error(): Response
    {
        return $this->render('error/404.html.twig');
    }
}
