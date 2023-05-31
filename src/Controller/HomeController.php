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

        $input = $search ?: $request->request;

        if($input){
            if ($this->isGranted('ROLE_DEV')){
                $searchResult = $companyRepository->findByString($input, $page);
            }elseif($this->isGranted('ROLE_COMPANY')){
                $searchResult = $developerRepository->findByString($input, $page);  
            }elseif($this->isGranted('ROLE_ADMIN')){
                $searchResult = $companyRepository->findByString($input, $page);
                $searchResult = array_merge($searchResult, $developerRepository->findByString($input, $page));  
            }
        }else{
            if ($this->isGranted('ROLE_COMPANY')){
                $searchResult = $developerRepository->findAll();
            } elseif ($this->isGranted('ROLE_DEV')){
                $searchResult = $companyRepository->findAll();
            } elseif($this->isGranted('ROLE_ADMIN')){
                $searchResult = $companyRepository->findAll();
                $searchResult = array_merge($searchResult, $developerRepository->findAll());
            }
        }

        return $this->render("home/index.html.twig", [
            'result'  => $searchResult,
            'search' => $search ?: $input->get('search'),
            'name' => $input->get('name'),
            'presentation' => $input->get('presentation'),
            'specialities' => $input->get('specialities'),
            'activities' => $input->get('activities'),
            'nav_search' => false,
        ]);
    }
}
