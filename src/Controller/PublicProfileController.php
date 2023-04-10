<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicProfileController extends AbstractController
{
    #[Route('/public/profile', name: 'app_public_profile')]
    public function index(): Response
    {
        return $this->render('public_profile/index.html.twig', [
            'controller_name' => 'PublicProfileController',
        ]);
    }
}
