<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Compte user

        $user = new User();
        $user->setNom('Doe');
        $user->setPrenom('John');
        $user->setEmail('user@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setActif(true);
        $hash = $this->userPasswordHasher->hashPassword($user, "user");
        $user->setPassword($hash);

        $manager->persist($user);

        // Compte admin

        $admin = new User();
        $admin->setNom('Briand');
        $admin->setPrenom('Vincent');
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setActif(true);
        $passHash = $this->userPasswordHasher->hashPassword($admin, "admin");
        $admin->setPassword($passHash);

        $manager->persist($admin);

        $manager->flush();
    }
}
