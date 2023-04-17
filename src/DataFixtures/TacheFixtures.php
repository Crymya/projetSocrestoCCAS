<?php

namespace App\DataFixtures;

use App\Entity\Tache;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TacheFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // zone cuisine et plonge 1
        // taches quotidiennes

        $tache18= new Tache();
        $tache18->setLibelle('Four de réchauffe');
        $manager->persist($tache18);
        $this->addReference('tachequocp1', $tache18);

        $tache19 = new Tache();
        $tache19->setLibelle('Four micro-onde');
        $manager->persist($tache19);
        $this->addReference('tachequocp2', $tache19);

        $tache27 = new Tache();
        $tache27->setLibelle('Poubelle');
        $manager->persist($tache27);
        $this->addReference('tachequocp3', $tache27);

        $tache3 = new Tache();
        $tache3->setLibelle('Poignet de porte');
        $manager->persist($tache3);
        $this->addReference('tachequocp4', $tache3);

        $tache13 = new Tache();
        $tache13->setLibelle('Laves mains');
        $manager->persist($tache13);
        $this->addReference('tachequocp5', $tache13);

        // deux fois par jour

        $tache14 = new Tache();
        $tache14->setLibelle('Sol grilles siphons');
        $manager->persist($tache14);
        $this->addReference('tachequo2cp1', $tache14);

        $tache15 = new Tache();
        $tache15->setLibelle('Ustensils');
        $manager->persist($tache15);
        $this->addReference('tachequo2cp2', $tache15);

        $tache20 = new Tache();
        $tache20->setLibelle('Passe plats');
        $manager->persist($tache20);
        $this->addReference('tachequo2cp3', $tache20);

        $tache21 = new Tache();
        $tache21->setLibelle('Bain marie');
        $manager->persist($tache21);
        $this->addReference('tachequo2cp4', $tache21);

        //taches hebdomadaire

        $tache24 = new Tache();
        $tache24->setLibelle('Armoire à balais');
        $manager->persist($tache24);
        $this->addReference('tachehebdocp1', $tache24);

        // après chaque utilisation pas de notion de temporalité

        $tache16 = new Tache();
        $tache16->setLibelle('Friteuse');
        $manager->persist($tache16);
        $this->addReference('tacheutilcp1', $tache16);

        $tache17 = new Tache();
        $tache17->setLibelle('Feux vif-fourneaux');
        $manager->persist($tache17);
        $this->addReference('tacheutilcp2', $tache17);

        // taches mensuelles

        $tache23 = new Tache();
        $tache23->setLibelle('Murs et portes');
        $manager->persist($tache23);
        $this->addReference('tachemenscp1', $tache23);

        // deux fois par mois

        $tache22 = new Tache();
        $tache22->setLibelle('Filtres hottes');
        $manager->persist($tache22);
        $this->addReference('tachemens2cp1', $tache22);

        $tache25 = new Tache();
        $tache25->setLibelle('Chambre froide n°1');
        $manager->persist($tache25);
        $this->addReference('tachemens2cp2', $tache25);

        $tache26 = new Tache();
        $tache26->setLibelle('Chambre froide n°2');
        $manager->persist($tache26);
        $this->addReference('tachemens2cp3', $tache26);


        // zone réfectoire 2
        // taches quotidiennes

        $tache2 = new Tache();
        $tache2->setLibelle('Tables & chaises');
        $manager->persist($tache2);
        $this->addReference('tachequor1', $tache2);

        $tache3 = new Tache();
        $tache3->setLibelle('Poignet de porte');
        $manager->persist($tache3);
        $this->addReference('tachequor2', $tache3);

        $tache4 = new Tache();
        $tache4->setLibelle('Interrupteur');
        $manager->persist($tache4);
        $this->addReference('tachequor3', $tache4);

        $tache10 = new Tache();
        $tache10->setLibelle('Fontaine à eaux');
        $manager->persist($tache10);
        $this->addReference('tachequor4', $tache10);

        $tache11 = new Tache();
        $tache11->setLibelle('Chariots');
        $manager->persist($tache11);
        $this->addReference('tachequor5', $tache11);

        $tache12 = new Tache();
        $tache12->setLibelle('Toilettes');
        $manager->persist($tache12);
        $this->addReference('tachequor6', $tache12);

        $tache13 = new Tache();
        $tache13->setLibelle('Laves mains');
        $manager->persist($tache13);
        $this->addReference('tachequor7', $tache13);

        //deux fois par jour

        $tache1 = new Tache();
        $tache1->setLibelle('Sols - plaintes');
        $manager->persist($tache1);
        $this->addReference('tachequo2r1', $tache1);

        $tache6 = new Tache();
        $tache6->setLibelle('Ordinateur');
        $manager->persist($tache6);
        $this->addReference('tachequo2r2', $tache6);

        //taches mensuelles

        $tache7 = new Tache();
        $tache7->setLibelle('Vitres');
        $manager->persist($tache7);
        $this->addReference('tachemensr1', $tache7);

        $tache8 = new Tache();
        $tache8->setLibelle('Rebords fenêtres');
        $manager->persist($tache8);
        $this->addReference('tachemensr2', $tache8);

        $tache9 = new Tache();
        $tache9->setLibelle('Murs');
        $manager->persist($tache9);
        $this->addReference('tachemensr3', $tache9);


        // deux fois par mois

        $tache5= new Tache();
        $tache5->setLibelle('Pieds de chaise et de table');
        $manager->persist($tache5);
        $this->addReference('tachemens2r1', $tache5);


        $manager->flush();
    }
}
