<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\ListeDesTaches;
use App\Entity\Periodicite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ListeTachesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');


        // Tâches pour la première zone
        $lieu = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Zone cuisine et plonge']);
        $periodicite = $manager->getRepository(Periodicite::class)->findAll();

        for ($i=1; $i < 17; $i++)
        {
            $tache = new ListeDesTaches();
            $tache->setNom($faker->sentence(3));
            $tache->setLieu($lieu);
            $tache->setPeriodicite($periodicite[mt_rand(0, count($periodicite) - 1)]);

            $manager->persist($tache);
        }

        // Tâches pour la deuxième zone
        $lieu = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Zone réfectoire, hall entrée et bureau']);
        $periodicite = $manager->getRepository(Periodicite::class)->findAll();

        for ($i=1; $i < 14; $i++)
        {
            $tache = new ListeDesTaches();
            $tache->setNom($faker->sentence(3));
            $tache->setLieu($lieu);
            $tache->setPeriodicite($periodicite[mt_rand(0, count($periodicite) - 1)]);

            $manager->persist($tache);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [LieuFixtures::class, PeriodiciteFixtures::class];
    }
}
