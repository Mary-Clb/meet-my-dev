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
    // #[Route('/search/{search}', name: 'app_home_search')]
    // #[Route('/search/{search}/{page}', name: 'app_home_search_pages')]
    public function index(/*?string $search, ?int $page, */Request $request, DeveloperRepository $repoDev): Response
    {   
        $user_role = $this->getUser()->getRoles();
        $role = "";
        $searchResult = [];

        $search = $request->request->get("search");
        if($search){
            $searchResult = $repoDev->findByString($search/*, $page, 10*/);
        }

        if (in_array('ROLE_DEV', $user_role)) {
            $role = "dev";
            return $this->render("home/dev.html.twig", [
                'searchResult' => $searchResult
            ]);
        }
        if (in_array('ROLE_COMPANY', $user_role)) {
            $role = "company";
            return $this->render("home/company.html.twig", [
                'searchResult' => $searchResult
            ]);
        }

        return $this->render("base.html.twig", [
            'searchResult' => $searchResult
        ]);
    }
}
