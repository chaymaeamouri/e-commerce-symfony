<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Affiche le formulaire de connexion et gère les erreurs d'authentification.
     * Redirige l'utilisateur vers l'accueil s'il est déjà connecté.
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(RegistrationFormType::class, new User());

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'registrationForm' => $form->createView()
        ]);
    }

    /**
     * Gère la déconnexion de l'utilisateur.
     * Cette méthode est interceptée par le pare-feu de sécurité de Symfony.
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
