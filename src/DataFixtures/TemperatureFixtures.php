<?php

namespace App\DataFixtures;

use App\Entity\Editeur;
use App\Entity\Materiel;
use App\Entity\Temperature;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TemperatureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $editeur = $manager->getRepository(Editeur::class)->findAll();

        // Températures pour Frigo n°1

        $materiel = $manager->getRepository(Materiel::class)->findOneBy(['nom' => 'Frigo n°1']);

        for ($i = 1; $i <=5; $i++)
        {
            $temperature = new Temperature();
            $temperature->setEditeur($editeur[mt_rand(0, count($editeur) - 1)]);
            $temperature->setMateriel($materiel);
            $temperature->setValeur($faker->numberBetween(0, 6));
            $temperature->setDateControle($faker->dateTimeBetween('-20 days', '-1 day'));

            $manager->persist($temperature);
        }

        // Température pour Frigo n°2

        $materiel = $manager->getRepository(Materiel::class)->findOneBy(['nom' => 'Frigo n°2']);

        for ($i = 1; $i <=5; $i++)
        {
            $temperature = new Temperature();
            $temperature->setEditeur($editeur[mt_rand(0, count($editeur) - 1)]);
            $temperature->setMateriel($materiel);
            $temperature->setValeur($faker->numberBetween(0, 6));
            $temperature->setDateControle($faker->dateTimeBetween('-20 days', '-1 day'));

            $manager->persist($temperature);
        }

        // Température pour Congélateur n°1

        $materiel = $manager->getRepository(Materiel::class)->findOneBy(['nom' => 'Congélateur n°1']);

        for ($i = 1; $i <=5; $i++)
        {
            $temperature = new Temperature();
            $temperature->setEditeur($editeur[mt_rand(0, count($editeur) - 1)]);
            $temperature->setMateriel($materiel);
            $temperature->setValeur($faker->numberBetween(-28, -17));
            $temperature->setDateControle($faker->dateTimeBetween('-20 days', '-1 day'));

            $manager->persist($temperature);
        }

        // Température pour Congélateur n°2

        $materiel = $manager->getRepository(Materiel::class)->findOneBy(['nom' => 'Congélateur n°2']);

        for ($i = 1; $i <=5; $i++)
        {
            $temperature = new Temperature();
            $temperature->setEditeur($editeur[mt_rand(0, count($editeur) - 1)]);
            $temperature->setMateriel($materiel);
            $temperature->setValeur($faker->numberBetween(-28, -17));
            $temperature->setDateControle($faker->dateTimeBetween('-20 days', '-1 day'));

            $manager->persist($temperature);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [MaterielFixtures::class, EditeurFixtures::class];
    }
}
