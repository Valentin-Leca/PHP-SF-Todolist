<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils) {

        return $this->render('security/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(), // last username entered by the user
            'error' => $authUtils->getLastAuthenticationError(), // get the login error if there is one
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck() {

        // This code is never executed.
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutCheck() {

        // This code is never executed.
    }
}
