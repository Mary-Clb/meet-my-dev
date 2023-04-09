<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Developer;
use App\Form\DevType;
use App\Form\CompanyType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/registerDev', name: 'app_register_dev')]
    #[Route('/registerCompany', name: 'app_register_company')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        switch($request->getPathInfo()){
            case "/registerDev":
                    $user = new Developer();
                    $form = $this->createForm(DevType::class, $user);
                    $type = "dev";
                break;
            case "/registerCompany": 
                    $user = new Company();
                    $form = $this->createForm(CompanyType::class, $user);
                    $type = "company";
                break;
            default: return $this->redirectToRoute("home");
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
                case "dev": $user->setRoles( array('ROLE_DEV') );
                    break;
                case "company" : $user->setRoles( array('ROLE_COMPANY') );
            }
            $entityManager->persist($user);
            $entityManager->flush();

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

}
