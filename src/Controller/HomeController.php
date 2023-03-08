<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        $user_role = $this->getUser()->getRoles();

        if (in_array('ROLE_DEV', $user_role)) {
            return $this->render('home/dev.html.twig');
        }
        if (in_array('ROLE_COMPANY', $user_role)) {
            return $this->render('home/company.html.twig');

        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
