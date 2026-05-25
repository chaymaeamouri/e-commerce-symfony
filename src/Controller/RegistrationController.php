<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * Gère l'inscription d'un nouvel utilisateur.
     * Traite les requêtes GET (affichage du formulaire) et POST (soumission des données).
     */
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserService $userService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->registerUser(
                $user,
                $form->get('plainPassword')->getData()
            );

            $this->addFlash('success', 'Votre compte a été créé avec succès !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('login.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
