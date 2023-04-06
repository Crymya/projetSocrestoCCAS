<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaterielFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 2; $i++)
        {
            $materiel = new Materiel();
            $materiel->setNom('Frigo n°' . $i);
            $materiel->setTempMax(6);

            $manager->persist($materiel);
        }

        for ($j = 1; $j <= 2; $j++)
        {
            $materiel2 = new Materiel();
            $materiel2->setNom('Congélateur n°' . $j);
            $materiel2->setTempMax(-17);

            $manager->persist($materiel2);
        }

        $manager->flush();
    }
}
