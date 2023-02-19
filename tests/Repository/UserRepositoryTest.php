<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase {

//    public function testSave() {
//
//        $client = static::createClient();
//
//        $newUser = new User();
//        $newUser->setUsername('testSave');
//        $newUser->setPassword('testSave');
//        $newUser->setEmail('test.save@testsave.fr');
//        $newUser->setRoles(['ROLE_USER']);
//
//        static::getContainer()->set(UserRepository::class)->save($newUser);
//
//        $this->assertNotNull(static::getContainer()->get(UserRepository::class)->findOneByUsername('testSave'));
//    }

    public function testRemove() {

        $userToDelete = static::getContainer()->get(UserRepository::class)->findOneByUsername('jean');
        $userRepository = static::getContainer()->get(UserRepository::class);

        $userRepository->remove($userToDelete, true);

        $this->assertNull(static::getContainer()->get(UserRepository::class)->findOneByUsername('jean'));
    }

}