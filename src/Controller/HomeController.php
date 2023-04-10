<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DeveloperRepository;
use App\Repository\CompanyRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/search/{search}', name: 'app_home_search')]
    #[Route('/search/{search}/{page}', name: 'app_home_search_pages')]
    public function index(?string $search = '', ?int $page = 0, Request $request, DeveloperRepository $developerRepository, CompanyRepository $companyRepository): Response
    {
        $searchResult = [];

        $search = $search ?: $request->request->get("search");
        
        if($search){
            if ($this->isGranted('ROLE_DEV')){
                $searchResult = $companyRepository->findByString($search, $page);
            }elseif($this->isGranted('ROLE_COMPANY')){
                $searchResult = $developerRepository->findByString($search, $page);  
            }
        }

        return $this->render("home/index.html.twig", [
            'result' => $searchResult
        ]);
    }
}
