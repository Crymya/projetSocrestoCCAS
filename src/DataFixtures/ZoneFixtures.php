<?php

namespace App\DataFixtures;

use App\Entity\Zone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $zone = new Zone();
        $zone->setLibelle('Zone cuisine et plonge');
        $manager->persist($zone);
        $this->addReference('zone1', $zone);

        $zone2 = new Zone();
        $zone2->setLibelle('Zone refectoire');
        $manager->persist($zone2);
        $this->addReference('zone2', $zone2);

        $manager->flush();
    }
}
