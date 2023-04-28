<?php

namespace App\Controller;

use App\Entity\TacheRealisee;
use App\Entity\Travail;
use App\Entity\TypePeriode;
use App\Entity\Zone;
use App\Form\TravailType;
use App\Repository\TachePrevueRepository;
use App\Repository\TacheRealiseeRepository;
use App\Repository\TravailRepository;
use App\Repository\TypePeriodeRepository;
use App\Repository\ZoneRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/travail')]
class TravailController extends AbstractController
{
    #[Route('/{idZone}/{idPeriode}', name: 'app_travail', requirements: ['idZone' => '\d+', 'idPeriode' => '\d+'], defaults: ['idZone' => 1/*3*/, 'idPeriode' => 1/*4*/])]
    #[ParamConverter('zone', options: ['mapping' => ['idZone' => 'id']])]
    #[ParamConverter('periode', options: ['mapping' => ['idPeriode' => 'id']])]
    public function pointageTaches(
        ?Zone $zone,
        ?TypePeriode $periode,
        Request $request,
        TravailRepository $travailRepository,
        TachePrevueRepository $tachePrevueRepository,
        TypePeriodeRepository $typePeriodeRepository,
        ZoneRepository $zoneRepository
    ): Response
    {
        // On récupère toutes les périodes
        $toutesPeriodes = $typePeriodeRepository->findAll();
        //On récupère toutes les zones
        $toutesZones = $zoneRepository->findAll();
        // On vérifie si la zone existe et si la période existe, sinon on lève une exception
        if (!$zone) {
            throw $this->createNotFoundException('Zone inconnue');
        }
        if (!$periode) {
            throw $this->createNotFoundException('Periode inconnue');
        }
        // Vérification des périodes en fonction du libellé
        if ($periode->getLibelle() == 'Taches quotidiennes') {
            $dateDebut = new \DateTime('today');
            $dateFin = new \DateTime('today');
        }

        if (($periode->getLibelle() == 'Taches hebdomadaire')) {
            $dateDebut = new \DateTime('today');
            $clone = clone $dateDebut;
            $dateFin = $clone->modify('next week');
        }

        if (($periode->getLibelle() == 'Taches mensuelles')) {
            $dateDebut = new \DateTime('today');
            $clone = clone $dateDebut;
            $dateFin = $clone->modify('last day of this month');
        }
        // On récupère un travail en fonction de la zone, de la période, date début et date fin
        $travail = $travailRepository->findOneBy(['zone' => $zone, 'periode' => $periode, 'dateDebut' => $dateDebut, 'dateFin' => $dateFin]);
        // Si elle n'existe pas on fait une nouvelle instance
        if (!$travail)
        {
            $travail = new Travail();
            $travail->setZone($zone);
            $travail->setPeriode($periode);
            $travail->setDateDebut($dateDebut);
            $travail->setDateFin($dateFin);
            // On récupère les tâches qui sont prévues en fonction de la zone et de la période
            $tachesPrevues = $tachePrevueRepository->getTaches($zone, $periode);

            // On boucle dessus et on instancie une tache réalisée en lui affectant la tache
            foreach ($tachesPrevues as $tachesPrevue)
            {
                $tacheRealisee = new TacheRealisee();
                $tacheRealisee->setTache($tachesPrevue->getTache());
                $travail->addTacheRealisee($tacheRealisee);
            }
            // Persist et flush le travail
            $travailRepository->add($travail, true);
        }
        //On créé le formulaire
        $form = $this->createForm(TravailType::class, $travail);
        $form->handleRequest($request);

        // Vérification et validation du formulaire
        if ($form->isSubmitted() && $form->isValid())
        {
            $travailRepository->add($travail, true);

            $this->addFlash('success', 'Tâche(s) enregistrée(s) avec succès !');
        }

        return $this->render('travail/pointage.html.twig', [
            'form' => $form->createView(),
            'zone' => $zone,
            'periode' => $periode,
            'zones' => $toutesZones,
            'typePeriode' => $toutesPeriodes,
        ]);
    }

    #[Route('/list', name: 'app_travail_list', methods: ['GET'])]
    public function list(TacheRealiseeRepository $tacheRealiseeRepository): Response
    {
        return $this->render('travail/list.html.twig', [
            // On récupère que les tâches qui ont été réalisées
            'taches' => $tacheRealiseeRepository->findBy(['realisee' => true]),
        ]);
    }
}
