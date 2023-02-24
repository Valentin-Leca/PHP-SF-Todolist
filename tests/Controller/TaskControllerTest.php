<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TaskControllerTest extends WebTestCase {

    public function testTaskUserAuthorizedAccess() {

        $client = static::createClient();
        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/tasks');
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('task_list');
    }

    public function testTaskOverUserAuthorizedAccess() {

        $client = static::createClient();
        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/tasks/over');
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('task_over');
    }

    public function testCreateTask() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $crawler = $client->request(Request::METHOD_GET, '/tasks/create');

        $buttonCrawler = $crawler->selectButton('Ajouter');
        $form = $buttonCrawler->form();

        $client->submit($form, [
            'task[title]' => 'Test title',
            'task[content]' => 'Test Content'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
    }

    public function testEditTaskAuthorizedAccess() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test title');

        $crawler = $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/edit');

        $buttonCrawler = $crawler->selectButton('Modifier');
        $form = $buttonCrawler->form();

        $client->submit($form, [
            'task[title]' => 'Test update title',
            'task[content]' => 'Test update Content'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
    }

    public function testEditTaskAccesDenied() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Anonyme');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test update title');

        $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/edit');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testToggleTaskAccessDenied() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Anonyme');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test update title');

        $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/toggle');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testToggleTask() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test update title');

        $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/toggle');

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
    }

    public function testDeleteTaskAccessDenied() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Anonyme');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test update title');

        $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/delete');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeleteTask() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $toEditTask = static::getContainer()->get(TaskRepository::class)->findOneByTitle('Test update title');

        $client->request(Request::METHOD_GET, '/tasks/'.$toEditTask->getId().'/delete');

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
    }
}
