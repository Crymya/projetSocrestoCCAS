<?php

namespace App\DataFixtures;

use App\Entity\Periodicite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeriodiciteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $periodicite = new Periodicite();
        $periodicite->setDescription('Une fois par jour');
        $periodicite->setPeriode('Jour');
        $periodicite->setRecurrence(1);

        $manager->persist($periodicite);

        $periodicite2 = new Periodicite();
        $periodicite2->setDescription('Une fois par mois');
        $periodicite2->setPeriode('Mois');
        $periodicite2->setRecurrence(1);

        $manager->persist($periodicite2);

        $periodicite3 = new Periodicite();
        $periodicite3->setDescription('Une fois par semaine');
        $periodicite3->setPeriode('Semaine');
        $periodicite3->setRecurrence(1);

        $manager->persist($periodicite3);

        $periodicite4 = new Periodicite();
        $periodicite4->setDescription('Deux fois par jour');
        $periodicite4->setPeriode('Jour');
        $periodicite4->setRecurrence(2);

        $manager->persist($periodicite4);

        $periodicite5 = new Periodicite();
        $periodicite5->setDescription('Deux fois par mois');
        $periodicite5->setPeriode('Mois');
        $periodicite5->setRecurrence(2);

        $manager->persist($periodicite5);


        $manager->flush();
    }
}
