<?php

namespace App\DataFixtures;

use App\Entity\Editeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EditeurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 4; $i++)
        {
            $editeur = new Editeur();
            $editeur->setNom($faker->lastName);
            $editeur->setPrenom($faker->firstName);
            $editeur->setActif(true);

            $manager->persist($editeur);
        }

        $manager->flush();
    }
}
