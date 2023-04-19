<?php

namespace App\Controller;

use App\Entity\TacheRealisee;
use App\Entity\Travail;
use App\Entity\TypePeriode;
use App\Entity\Zone;
use App\Form\Travail1Type;
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
    #[Route('/{idZone}/{idPeriode}', name: 'app_travail', requirements: ['idZone' => '\d+', 'idPeriode' => '\d+'], defaults: ['idZone' => 3, 'idPeriode' => 4])]
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
        $toutesPeriodes = $typePeriodeRepository->findAll();
        $toutesZones = $zoneRepository->findAll();

        if (!$zone) {
            throw $this->createNotFoundException('Zone inconnue');
        }
        if (!$periode) {
            throw $this->createNotFoundException('Periode inconnue');
        }

        if ($periode->getLibelle() == 'Taches quotidiennes') {
            $dateDebut = new \DateTime();
            $dateFin = new \DateTime();
        }

        if (($periode->getLibelle() == 'Taches hebdomadaire')) {
            $dateDebut = new \DateTime();
            $clone = clone $dateDebut;
            $dateFin = $clone->modify('next week');
        }

        if (($periode->getLibelle() == 'Taches mensuelles')) {
            $dateDebut = new \DateTime();
            $clone = clone $dateDebut;
            $dateFin = $clone->modify('last day of this month');
        }

        $travail = $travailRepository->findOneBy(['zone' => $zone, 'periode' => $periode, 'dateDebut' => $dateDebut, 'dateFin' => $dateFin]);

        if (!$travail)
        {
            $travail = new Travail();
            $travail->setZone($zone);
            $travail->setPeriode($periode);
            $travail->setDateDebut($dateDebut);
            $travail->setDateFin($dateFin);

            $tachesPrevues = $tachePrevueRepository->getTaches($zone, $periode);


            foreach ($tachesPrevues as $tachesPrevue)
            {
                $tacheRealisee = new TacheRealisee();
                $tacheRealisee->setTache($tachesPrevue->getTache());
                $travail->addTacheRealisee($tacheRealisee);
            }

            $travailRepository->add($travail, true);
        }

        $form = $this->createForm(TravailType::class, $travail);
        $form->handleRequest($request);


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
            'taches' => $tacheRealiseeRepository->findBy(['realisee' => true]),
        ]);
    }


    /*#[Route('/new', name: 'app_travail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TravailRepository $travailRepository): Response
    {
        $travail = new Travail();
        $form = $this->createForm(Travail1Type::class, $travail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travailRepository->save($travail, true);

            return $this->redirectToRoute('app_travail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travail/new.html.twig', [
            'travail' => $travail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_travail_show', methods: ['GET'])]
    public function show(Travail $travail): Response
    {
        return $this->render('travail/show.html.twig', [
            'travail' => $travail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_travail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travail $travail, TravailRepository $travailRepository): Response
    {
        $form = $this->createForm(Travail1Type::class, $travail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travailRepository->save($travail, true);

            return $this->redirectToRoute('app_travail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travail/edit.html.twig', [
            'travail' => $travail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_travail_delete', methods: ['POST'])]
    public function delete(Request $request, Travail $travail, TravailRepository $travailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travail->getId(), $request->request->get('_token'))) {
            $travailRepository->remove($travail, true);
        }

        return $this->redirectToRoute('app_travail_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
