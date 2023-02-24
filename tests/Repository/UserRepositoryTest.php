<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase {

    public function testUserSave() {

        self::bootKernel();

        $newUser = new User();
        $newUser->setUsername('testSave');
        $newUser->setPassword('testSave');
        $newUser->setEmail('test.save@testsave.fr');
        $newUser->setRoles(['ROLE_USER']);

        $this->assertInstanceOf(User::class, $newUser);

        $userRepository = new UserRepository(static::getContainer()->get(ManagerRegistry::class));
        $userRepository->save($newUser, true);


        $this->assertNotNull($userRepository->findOneByUsername('testSave'));
    }

    public function testUserRemove() {

        self::bootKernel();

        $userRepository = new UserRepository(static::getContainer()->get(ManagerRegistry::class));

        $user = $userRepository->findOneBy(['username' => 'testSave']);
        $this->assertInstanceOf(User::class, $user);

        $userRepository->remove($user, true);

        $this->assertNull($userRepository->findOneBy(['username' => 'testSave']));
    }
}