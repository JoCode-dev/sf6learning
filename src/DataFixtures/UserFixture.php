<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 2; $i++) {
            # code...
            $admin = new User();
            $admin->setUsername('admin' . $i);
            $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
            $admin->setRoles(['ROLE_ADMIN']);

            $manager->persist($admin);
        }

        for ($i = 0; $i < 5; $i++) {
            # code...
            $user = new User();
            $user->setUsername("user$i");
            $user->setPassword($this->hasher->hashPassword($user, 'user'));
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
