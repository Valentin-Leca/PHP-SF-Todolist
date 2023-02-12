<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testUser() {

        $user = new User();

        $user->setUsername('Valentin');
        $user->setEmail('valentin.valentin@outlook.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('test');
        $user->addTask($task = new Task());

        $this->assertEquals('Valentin', $user->getUsername());
        $this->assertEquals('valentin.valentin@outlook.com', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('test', $user->getPassword());
        $this->assertNull($user->getId());
        $this->assertNull($user->getSalt());
        $this->assertNull($user->eraseCredentials());
        $this->assertEquals($user->getUsername(), $user->getUserIdentifier());
        $this->assertContains($task, $user->getTasks());

        $user->removeTask($task);
        $this->assertNotContains($task, $user->getTasks());
    }
}
