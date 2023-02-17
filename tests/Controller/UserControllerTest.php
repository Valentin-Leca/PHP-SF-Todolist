<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class UserControllerTest extends WebTestCase {

    public function testListUserAuthorizedAccess() {

        $client = static::createClient();
        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/users');
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('user_list');
    }

    public function testListUserForbiddenAccess() {

        $client = static::createClient();
        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Anonyme');
        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testUserCreate() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $crawler = $client->request(Request::METHOD_GET, '/users/create');

        $buttonCrawler = $crawler->selectButton('Ajouter');
        $form = $buttonCrawler->form();

        $client->submit($form, [
            'user[username]' => 'jean',
            'user[password][first]' => 'jean',
            'user[password][second]' => 'jean',
            'user[email]' => 'test.jean@test.fr',
            'user[roles]' => 'ROLE_USER'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('user_list');
    }

    public function testEditUser() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $toEditUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('jean');

        $crawler = $client->request(Request::METHOD_GET, '/users/'.$toEditUser->getId().'/edit');

        $buttonCrawler = $crawler->selectButton('Modifier');
        $form = $buttonCrawler->form();

        $client->submit($form, [
            'user[username]' => 'jean',
            'user[password][first]' => 'jean',
            'user[password][second]' => 'jean',
            'user[email]' => 'jean.jean@test.fr',
            'user[roles]' => 'ROLE_USER'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('user_list');
    }
}
