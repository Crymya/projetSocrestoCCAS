<?php

namespace App\DataFixtures;

use App\Entity\TypePeriode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypePeriodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $periode = new TypePeriode();
        $periode->setLibelle('Taches quotidiennes');
        $manager->persist($periode);
        $this->addReference('periode1', $periode);

        $periode2 = new TypePeriode();
        $periode2->setLibelle('Taches hebdomadaire');
        $manager->persist($periode2);
        $this->addReference('periode2', $periode2);

        $periode3 = new TypePeriode();
        $periode3->setLibelle('Taches mensuelles');
        $manager->persist($periode3);
        $this->addReference('periode3', $periode3);

        $manager->flush();
    }
}
