<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{    
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $specialities = ['PHP', 'Symfony', 'Javascript', 'React.js', 'Vue.js', 'Bootstrap', 'C#', 'C++', "Python"];

        foreach ($specialities as $i => $spe) {
            $speciality = new Speciality();
            $speciality->setLabel($spe);
            $manager->persist($speciality);
            $specialities[$i] = $speciality;
        }

        $developers = Array();
        for ($i = 0; $i < 4; $i++) {
            $developers[$i] = new Developer();
            $developers[$i]->setname($faker->lastName);
            $developers[$i]->setfirstname($faker->firstName);
            $developers[$i]->setExperience($faker->numberBetween(0, 40));
            $developers[$i]->setPresentation('jkljkljhjkhkgbjh jhhbjgk kbhjg bkjbkjbl16584110.0');
            $developers[$i]->addSpeciality($specialities[rand(0, 8)]);
            $developers[$i]->setUsername('Toto' . $i);
            $developers[$i]->setMail($faker->email);
            $developers[$i]->setTelephone($faker->phoneNumber);
            $password = $this->hasher->hashPassword($developers[$i], 'mdp');
            $developers[$i]->setPassword($password);

            $manager->persist($developers[$i]);

        }
        $manager->flush();
    }
}
