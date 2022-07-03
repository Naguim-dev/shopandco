<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(
        UserPasswordHasherInterface $passwordEncoder,
        SluggerInterface $slugger
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@shopandco.com');
        $admin->setLastname('Jane');
        $admin->setFirstname('Doe');
        $admin->setAddress('rue de la chance');
        $admin->setCity('Moorea');
        $admin->setZipcode('98728');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');
        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setAddress($faker->streetAddress());
            $user->setCity($faker->city());
            $user->setZipcode(str_replace(' ', '', $faker->postcode()));
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }

        $manager->flush();
    }
}
