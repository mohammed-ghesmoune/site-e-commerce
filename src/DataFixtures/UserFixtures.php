<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {       
            $user = new User();
            $user->setEmail('john.doe@gmail.com')
                ->setPassword($this->passwordEncoder->encodePassword($user, 'abcd1234'));
            $manager->persist($user);
            $manager->flush();
    }
}

/*
 public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $civilities=['Male','Female'];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->passwordEncoder->encodePassword($user, '1234'));
            $manager->persist($user);
            for ($j = 0; $j < mt_rand(0, 3); $j++) {
                $civility=$faker->randomElement($civilities);
                $firstname='firstName'.$civility;
                $address = (new Address())
                    ->setCivility($civility)
                    ->setFirstname($faker->$firstname)
                    ->setLastname($faker->lastName)
                    ->setLine1($faker->streetAddress)
                    ->setPostalcode($faker->postcode)
                    ->setCity($faker->city)
                    ->setCountry($faker->country)
                    ->setPhone($faker->e164PhoneNumber)
                    ->setUser($user);

                $manager->persist($address);
            }
        }
        $manager->flush();
    }
    */