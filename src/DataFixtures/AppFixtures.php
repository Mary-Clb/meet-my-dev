<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Activity;
use App\Entity\Developer;
use App\Entity\Speciality;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        $activities = ["Industrie","Marketing","Développement web","Vente","Accompagnement","Santé"];

        foreach ($specialities as $i => $spe) {
            $speciality = new Speciality();
            $speciality->setLabel($spe);
            $manager->persist($speciality);
            $specialities[$i] = $speciality;
        }
        
        foreach ($activities as $i => $act) {
            $activity = new Activity();
            $activity->setLabel($act);
            $manager->persist($activity);
            $activities[$i] = $activity;
        }

        $developers = Array();
        for ($i = 0; $i < 4; $i++) {
            $developers[$i] = new Developer();
            $developers[$i]->setname($faker->lastName);
            $developers[$i]->setfirstname($faker->firstName);
            $developers[$i]->setExperience($faker->numberBetween(0, 40));
            $developers[$i]->setPresentation($faker->realText());
            $developers[$i]->addSpeciality($specialities[rand(0, 8)]);
            $developers[$i]->setUsername($faker->userName);
            $developers[$i]->setMail($faker->email);
            $developers[$i]->setTelephone($faker->phoneNumber);
            $password = $this->hasher->hashPassword($developers[$i], 'mdp');
            $developers[$i]->setPassword($password);

            $manager->persist($developers[$i]);
        }

        for ($i = 0; $i < 6; $i++) {
            $companies[$i] = new Company();
            $companies[$i]->setname($faker->company);
            $companies[$i]->setemployees($faker->numberBetween(0, 40));
            $companies[$i]->setSiret($faker->numberBetween(100000000, 999999999));
            $companies[$i]->setPresentation($faker->realText());
            $companies[$i]->setPublique($faker->boolean());
            $companies[$i]->addActivity($activities[rand(0, 5)]);
            $companies[$i]->setUsername($faker->userName);
            $companies[$i]->setMail($faker->email);
            $companies[$i]->setTelephone($faker->phoneNumber);
            $password = $this->hasher->hashPassword($companies[$i], 'mdp');
            $companies[$i]->setPassword($password);

            $manager->persist($companies[$i]);
        }

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN'])
        ->setUsername('admin')
        ->setMail('admin@mail.fr')
        ->setPassword($this->hasher->hashPassword($admin, 'admin'));

        $manager->persist($admin);
        $manager->flush();
    }
}
