<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/tasks')]
class TaskController extends AbstractController {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('', name:"task_list", methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function listTask(): Response {

        return $this->render('task/list.html.twig',
            ['tasks' => $this->entityManager->getRepository(Task::class)->findAll()]);
    }

    #[Route('/over', name:"task_over", methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function listTaskOver(): Response {

        return $this->render('task/list-over.html.twig',
            ['tasks' => $this->entityManager->getRepository(Task::class)->findBy(['isDone' => 1])]);
    }

    #[Route('/create', name:"task_create", methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function createTask(Request $request): Response {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setUser($this->getUser());
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name:"task_edit", methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function editTask(Task $task, Request $request): Response {

        if (in_array('ROLE_ADMIN',$this->getUser()->getRoles()) || $this->getUser() === $task->getUser()) {

            $form = $this->createForm(TaskType::class, $task);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $this->entityManager->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');

                return $this->redirectToRoute('task_list');
            }

            return $this->render('task/edit.html.twig', [
                'form' => $form->createView(),
                'task' => $task,
            ]);
        }
        throw $this->createAccessDeniedException();

    }

    #[Route('/{id}/toggle', name:"task_toggle", methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function toggleTask(Task $task): Response {

        if ($this->getUser() !== $task->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/{id}/delete', name:"task_delete", methods: ['GET', 'POST'])]
    public function deleteTask(Task $task): Response {

        if ($this->getUser() !== $task->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
