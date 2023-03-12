<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class DefaultController extends AbstractController
{
    #[Route('', name:"homepage", methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
