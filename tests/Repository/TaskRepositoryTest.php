<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase {

    public function testTaskSave() {

        self::bootKernel();

        $userRepository = new UserRepository(static::getContainer()->get(ManagerRegistry::class));
        $taskRepository = new TaskRepository(static::getContainer()->get(ManagerRegistry::class));

        $newTask = new Task();
        $newTask->setTitle('Task test title');
        $newTask->setContent('Task test content');
        $newTask->setCreatedAt(new \DateTimeImmutable());
        $newTask->setUser($userRepository->findOneByUsername('Valentin'));

        $this->assertInstanceOf(Task::class, $newTask);

        $taskRepository->save($newTask, true);

        $this->assertNotNull($taskRepository->findOneByTitle('Task test title'));
    }

    public function testTaskRemove() {

        self::bootKernel();

        $taskRepository = new TaskRepository(static::getContainer()->get(ManagerRegistry::class));

        $task = $taskRepository->findOneBy(['title' => 'Task test title']);
        $this->assertInstanceOf(Task::class, $task);

        $taskRepository->remove($task, true);

        $this->assertNull($taskRepository->findOneById($task->getId()));
    }
}