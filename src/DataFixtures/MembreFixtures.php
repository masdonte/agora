<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Generator;
use Faker\Factory;

use App\Entity\Membre;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $membre = new Membre();
            $membre->setUsername($this->faker->userName());
            $membre->setNomMembre($this->faker->lastName());
            $membre->setPrenomMembre($this->faker->firstName());
            $membre->setMailMembre(sprintf('userdemo%d@example.com', $i));
            $membre->setTelMembre(substr($this->faker->e164PhoneNumber(), 2, 10));
            $membre->setRueMembre($this->faker->streetAddress());
            $membre->setCpMembre($this->faker->postcode());
            $membre->setVilleMembre($this->faker->city());
            $membre->setPassword($this->passwordHasher->hashPassword($membre, 'userdemo'));
            $manager->persist($membre);
        }
        $manager->flush();
    }
}
