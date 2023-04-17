<?php

namespace App\DataFixtures;

use App\Entity\TachePrevue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TachePrevueFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Zone 1 cuisine et plonge & période 1 taches quotidiennes
        for ($i = 1 ; $i <= 5 ; $i++)
        {
            $tc = new TachePrevue();
            $tc->setZone($this->getReference('zone1'));
            $tc->setPeriode($this->getReference('periode1'));
            $tc->setTache($this->getReference('tachequocp'.$i));

            $manager->persist($tc);
        }

        for ($i = 1 ; $i <= 4 ; $i++)
        {
            $td = new TachePrevue();
            $td->setZone($this->getReference('zone1'));
            $td->setPeriode($this->getReference('periode1'));
            $td->setTache($this->getReference('tachequo2cp'.$i));

            $manager->persist($td);
        }

        // Zone 2 réfectoire & période 1 taches quotidiennes

        for ($i = 1 ; $i <= 7  ; $i++)
        {
            $te = new TachePrevue();
            $te->setZone($this->getReference('zone2'));
            $te->setPeriode($this->getReference('periode1'));
            $te->setTache($this->getReference('tachequor'.$i));

            $manager->persist($te);
        }

        for ($i = 1 ; $i <= 2  ; $i++)
        {
            $tf = new TachePrevue();
            $tf->setZone($this->getReference('zone2'));
            $tf->setPeriode($this->getReference('periode1'));
            $tf->setTache($this->getReference('tachequo2r'.$i));

            $manager->persist($tf);
        }

        // Zone 1 cuisine et plonge & période 2 taches hebdomadaire
        for ($i = 1 ; $i <= 1 ; $i++)
        {
            $tg = new TachePrevue();
            $tg->setZone($this->getReference('zone1'));
            $tg->setPeriode($this->getReference('periode2'));
            $tg->setTache($this->getReference('tachehebdocp1'));

            $manager->persist($tg);
        }

        // Zone 1 cuisine et plonge & période 3 taches mensuelles
        for ($i = 1 ; $i <= 1 ; $i++)
        {
            $th = new TachePrevue();
            $th->setZone($this->getReference('zone1'));
            $th->setPeriode($this->getReference('periode3'));
            $th->setTache($this->getReference('tachemenscp1'));

            $manager->persist($th);
        }

        for ($i = 1 ; $i <= 3 ; $i++)
        {
            $ti = new TachePrevue();
            $ti->setZone($this->getReference('zone1'));
            $ti->setPeriode($this->getReference('periode3'));
            $ti->setTache($this->getReference('tachemens2cp'.$i));

            $manager->persist($ti);
        }

        // Zone 2 réfectoire & période 3 taches mensuelles

        for ($i = 1 ; $i <= 3  ; $i++)
        {
            $tj = new TachePrevue();
            $tj->setZone($this->getReference('zone2'));
            $tj->setPeriode($this->getReference('periode3'));
            $tj->setTache($this->getReference('tachemensr'.$i));

            $manager->persist($tj);
        }

        for ($i = 1 ; $i <= 1  ; $i++)
        {
            $tk = new TachePrevue();
            $tk->setZone($this->getReference('zone2'));
            $tk->setPeriode($this->getReference('periode3'));
            $tk->setTache($this->getReference('tachemens2r1'));

            $manager->persist($tk);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TypePeriodeFixtures::class, TacheFixtures::class, ZoneFixtures::class];
    }
}
