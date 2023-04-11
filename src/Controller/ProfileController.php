<?php 

namespace App\Controller;

use App\Repository\SpecialityRepository;
use App\Form\EditProfileType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

        #[Route('/profile/{id}', name: 'app_public_profile')]
        public function publicProfil(int $id, UserRepository $userRepository): Response        
        {
            $user = $userRepository->findOneBy(['id' => $id]);
            return $this->render('public_profile/index.html.twig', [
                'user' => $user,
            ]);
        }

    #[Route('/profile/languages', name: 'app_profile_language')]
    public function searchNames(Request $request, SpecialityRepository $specialityRepository, SerializerInterface $serializer): JsonResponse
    {
        $filter = $request->query->get('filter');
        $specialities = [];
        if($filter){
            $specialities = $specialityRepository->findByLike($filter);
        }else{
            $specialities = $specialityRepository->findAll();
        }
        
        return new JsonResponse([
            'languages' => $serializer->serialize($specialities, 'json',['groups' => ['list_languages']]),
        ]);
    }

}
