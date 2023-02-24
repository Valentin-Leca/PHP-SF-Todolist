<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase {

    public function testTask() {

        $task = new Task();

        $task->setTitle('Test');
        $task->setContent('Ceci est une tâche de test !');
        $task->setCreatedAt($date = new \DateTimeImmutable());
        $task->setUser($user = new User());
        $task->toggle(false);

        $this->assertEquals('Test', $task->getTitle());
        $this->assertEquals('Ceci est une tâche de test !', $task->getContent());
        $this->assertEquals($task->getId(), $task->getId());
        $this->assertEquals($user, $task->getUser());
        $this->assertEquals($date, $task->getCreatedAt());
        $this->assertEquals(false, $task->isDone());
    }
}
