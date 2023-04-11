<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $lieu1 = new Lieu();
        $lieu1->setNom('Zone cuisine et plonge');


        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('Zone réfectoire, hall entrée et bureau');

        $manager->persist($lieu2);

        $manager->flush();
    }
}
