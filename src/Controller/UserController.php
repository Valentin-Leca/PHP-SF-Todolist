<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UserController extends AbstractController {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('', name:"user_list", methods: ['GET'])]
    public function listUser() {

        return $this->render('user/list.html.twig',
            ['users' => $this->entityManager->getRepository(User::class)->findAll()]
        );
    }

    #[Route('/create', name:"user_create", methods: ['GET', 'POST'])]
    public function createAction(Request $request, UserPasswordHasherInterface $hasher) {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', "L'utilisateur a bien été ajouté !");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name:"user_edit", methods: ['GET', 'POST'])]
    public function editUser(User $user, Request $request, UserPasswordHasherInterface $hasher) {

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));

            $this->entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié !");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
