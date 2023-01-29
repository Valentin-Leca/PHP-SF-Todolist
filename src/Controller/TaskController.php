<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks')]
class TaskController extends AbstractController {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('', name:"task_list", methods: ['GET'])]
    public function listTask(): Response {

        return $this->render('task/list.html.twig',
            ['tasks' => $this->entityManager->getRepository(Task::class)->findAll()]);
    }

    #[Route('/over', name:"task_over", methods: ['GET'])]
    public function listTaskOver(): Response {

        return $this->render('task/list-over.html.twig',
            ['tasks' => $this->entityManager->getRepository(Task::class)->findBy(['isDone' => 1])]);
    }

    #[Route('/create', name:"task_create", methods: ['GET', 'POST'])]
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
    public function editTask(Task $task, Request $request): Response {

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

    #[Route('/{id}/toggle', name:"task_toggle", methods: ['GET', 'POST'])]
    public function toggleTask(Task $task): Response {

        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/{id}/delete', name:"task_delete", methods: ['GET', 'POST'])]
    public function deleteTaskAction(Task $task): Response {

        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
