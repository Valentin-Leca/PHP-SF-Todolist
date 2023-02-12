<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends WebTestCase {

    public function testHomepage() {

        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame("homepage");
    }
}
