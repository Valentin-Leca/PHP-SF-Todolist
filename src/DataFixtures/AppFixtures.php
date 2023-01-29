<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {

        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void {

        $user = new User();
        $user->setUsername("anonyme");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'anonyme'));
        $user->setEmail("anonyme.anonyme@sfr.fr");
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);
        $manager->flush();

        $task = new Task();
        $task->setTitle("Titre accueil");
        $task->setContent("Aller sur la page d'accueil et centrer le titre.");
        $task->setCreatedAt(date_create());
        $task->setUser($user);
        $manager->persist($task);
        $manager->flush();

        $user = new User();
        $user->setUsername("Valentin");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'Valentin'));
        $user->setEmail("valentin.valentin@sfr.fr");
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();

        $task = new Task();
        $task->setTitle("Visuel");
        $task->setContent("Refaire le visuel de la page des tâche.");
        $task->setCreatedAt(date_create());
        $task->setUser($user);
        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setTitle("Tâches terminées");
        $task->setContent("Ajouter la liste des tâches terminées visible.");
        $task->setCreatedAt(date_create());
        $task->setUser($user);
        $manager->persist($task);
        $manager->flush();
    }
}
