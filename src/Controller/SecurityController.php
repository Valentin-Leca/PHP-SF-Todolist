<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController {

    #[Route('/login', name:"login", methods: ['GET', 'POST'])]
    public function login(Request $request, AuthenticationUtils $authUtils): Response {

        return $this->render('security/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(), // last username entered by the user
            'error' => $authUtils->getLastAuthenticationError(), // get the login error if there is one
        ));
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): void {
        // controller can be blank: it will never be called!
    }
}
