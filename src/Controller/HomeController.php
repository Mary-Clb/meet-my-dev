<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DeveloperRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/{search}', name: 'app_home_search')]
    #[Route('/{search}/{page}', name: 'app_home_search_pages')]
    public function index(?string $search, ?int $page, Request $request, DeveloperRepository $repoDev): Response
    {   
        $user_role = $this->getUser()->getRoles();
        $role = "";
        $searchResult = [];

        if (in_array('ROLE_DEV', $user_role)) {
            $role = "dev";
        }
        if (in_array('ROLE_COMPANY', $user_role)) {
            $role = "company";
        }

        $search = $request->request->get("search");
        if($search){
            $searchResult = $repoDev->findByString($search, $page, 10);
            dd($searchResult);
        }

        return $this->render("home/$role.html.twig", [
            'searchResult' => $searchResult
        ]);
    }
}
