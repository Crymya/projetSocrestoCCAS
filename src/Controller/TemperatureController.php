<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Materiel;
use App\Entity\Temperature;
use App\Form\ModificationTemperatureType;
use App\Form\SearchTemperatureType;
use App\Form\TemperatureType;
use App\Repository\MaterielRepository;
use App\Repository\TemperatureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/temperature')]
class TemperatureController extends AbstractController
{
    #[Route('/', name: 'app_temperature_index', methods: ['GET'])]
    public function index(Request $request,TemperatureRepository $temperatureRepository): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchTemperatureType::class, $data);
        $form->handleRequest($request);


        return $this->render('temperature/index.html.twig', [
            'temperatures' => $temperatureRepository->findSearch($data),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_temperature_new', methods: ['GET', 'POST'])]
    public function new(MaterielRepository $materielRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération de tous les matériels enregistrés en BDD
        $materiels = $materielRepository->findAll();

        // Ini d'un tableau de température vide
        $temperatures = [];

        // On boucle sur chaque matériel et on créé une instance de température qu'on ajoute au tableau
        foreach ($materiels as $materiel) {
            $temperature = new Temperature();
            $temperature->setMateriel($materiel);
            $temperatures[] = $temperature;
        }

        // On créé la collection de température
        $form = $this->createFormBuilder(['temperatures' => $temperatures])
            ->add('temperatures', CollectionType::class, [
                'entry_type' => TemperatureType::class,
                'allow_add' => false,
                'allow_delete' => false,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->getForm();

        // Savoir si c'est la méthode post qui est appellée
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            // On vérifie que le formulaire est conforme
            if ($form->isSubmitted() && $form->isValid()) {

                // On boucle sur les températures et on instancie à la date du jour,on persiste et on flush
                foreach ($temperatures as $temperature) {
                    $temperature->setDateControle(new DateTime());
                    $entityManager->persist($temperature);
                }

                $entityManager->flush();

                $this->addFlash('success', 'Temperatures enregistrées avec succès.');

                return $this->redirectToRoute('app_temperature_new');
            }
        }

        return $this->render('temperature/new.html.twig', [
            'form' => $form->createView(),
            'materiels' => $materiels,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_temperature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, TemperatureRepository $temperatureRepository): Response
    {
        $temperature = $temperatureRepository->find($id);
        $form = $this->createForm(ModificationTemperatureType::class, $temperature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temperatureRepository->save($temperature, true);

            $this->addFlash('success', 'Température modifiée avec succès !');

            return $this->redirectToRoute('app_temperature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/edit.html.twig', [
            'temperature' => $temperature,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/stats/{id}', name: 'app_temperature_stats', methods: ['GET'])]
    public function stats(Materiel $materiel, Request $request, TemperatureRepository $temperatureRepository, MaterielRepository $materielRepository, int $id): Response
    {
        $date = new \DateTime();
        $month = $request->query->getInt('month', $date->format('m'));

        $months = [
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre',
        ];

        $temperatures = $temperatureRepository->findByMonthAndMateriel($materiel, new \DateTime("2023-$month-01"));
        $materiels = $materielRepository->findAll();

        $dataDate = [];
        $dataValeur = [];

        foreach ($temperatures as $temperature) {
            $dataDate[] = $temperature->getDateControle()->format('d/m/Y H:i');
            $dataValeur[] = $temperature->getValeur();
        }

        return $this->render('temperature/stats.html.twig', [
            'materiels' => $materiels,
            'id' => $id,
            'dataDate' => json_encode($dataDate),
            'dataValeur' => json_encode($dataValeur),
            'month' => $month,
            'months' => $months
        ]);
    }

}
