<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    private Generator $faker;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->faker = Factory::create('fr_FR');
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //Admin
        $adminUser = new User();
        $adminUser
            ->setName('Service')
            ->setForname('Communication')
            ->setPhone($this->faker->randomDigit())
            ->setAgency('Centre')
            ->setEmail('communication@immoval.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($adminUser, 'adminpassword'));

        $manager->persist($adminUser);

        $manager->flush();
    
        //User Negociateurs
        for($i = 0; $i < 10; $i++){
            $user = new User();
            $user
            ->setName($this->faker->lastName())
            ->setForname($this->faker->firstName())
            ->setPhone($this->faker->randomDigit())
            ->setAgency($this->faker->word())
            ->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('password');

            $manager->persist($user);
        }

            $manager->flush();
    }
}