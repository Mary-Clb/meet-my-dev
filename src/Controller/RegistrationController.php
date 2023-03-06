<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Developer;
use App\Entity\Company;
use App\Form\DevType;
use App\Form\CompanyType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registerDev', name: 'app_register_dev')]
    #[Route('/registerCompany', name: 'app_register_company')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        if($request->getPathInfo() == "/registerDev"){
            $user = new Developer();
            $form = $this->createForm(DevType::class, $user);
            $type = "développeur";
        }elseif($request->getPathInfo() == "/registerCompany"){
            $user = new Company();
            $form = $this->createForm(CompanyType::class, $user);
            $type = "entreprise";
        }else{
            return $this->redirectToRoute("home");
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            switch($type) {
                case "développeur": $user->setRoles( array('ROLE_DEV') );
                    break;
                case "entreprise" : $user->setRoles( array('ROLE_COMPANY') );
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'type' => $type,
        ]);
    }

     #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('base.html.twig', [
        ]);
    }
}
