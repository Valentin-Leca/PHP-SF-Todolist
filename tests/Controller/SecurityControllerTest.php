<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class SecurityControllerTest extends WebTestCase {

    public function testLogin() {

        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/login');
        $this->assertRouteSame("login");
        $client->submitForm('Se connecter', [
            '_username' => 'Valentin',
            '_password' => 'Valentin'
        ]);

        $this->assertResponseRedirects("",302);
        $client->followRedirect();
        $this->assertRouteSame("homepage");
    }

    public function testLogoutCheck() {

        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUsername('Valentin');
        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/logout');
        $this->assertResponseRedirects("",302);
        $client->followRedirect();
        $this->assertRouteSame("homepage");

    }
}
