<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Materiel;
use App\Entity\Temperature;
use App\Form\ModificationTemperatureType;
use App\Form\SearchTemperatureType;
use App\Form\TemperatureType;
use App\Repository\EditeurRepository;
use App\Repository\MaterielRepository;
use App\Repository\TemperatureRepository;
use App\Tools\Modele;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new(Request $request, EntityManagerInterface $entityManager, MaterielRepository $materielRepository): Response
    {
        $modele = new Modele();
        $form = $this->createForm(TemperatureType::class, $modele);
        $form->handleRequest($request);

        $frigo1 = $materielRepository->findOneBy(['nom' => 'Frigo n°1']);
        $frigo2 = $materielRepository->findOneBy(['nom' => 'Frigo n°2']);
        $congelateur1 = $materielRepository->findOneBy(['nom' => 'Congélateur n°1']);
        $congelateur2 = $materielRepository->findOneBy(['nom' => 'Congélateur n°2']);


        if ($form->isSubmitted() && $form->isValid())
        {
            $temp1 = new Temperature();
            $temp1->setValeur($modele->temp1);
            $temp1->setDateControle(new \DateTime());
            $temp1->setEditeur($modele->editeur);
            $materiel1 = $materielRepository->findOneBy(['nom' => 'Frigo n°1']);
            $materiel1->addTemperature($temp1);

            $temp2 = new Temperature();
            $temp2->setValeur($modele->temp2);
            $temp2->setDateControle(new \DateTime());
            $temp2->setEditeur($modele->editeur);
            $materiel2 = $materielRepository->findOneBy(['nom' => 'Frigo n°2']);
            $materiel2->addTemperature($temp2);

            $temp3 = new Temperature();
            $temp3->setValeur($modele->temp3);
            $temp3->setDateControle(new \DateTime());
            $temp3->setEditeur($modele->editeur);
            $materiel3 = $materielRepository->findOneBy(['nom' => 'Congélateur n°1']);
            $materiel3->addTemperature($temp3);

            $temp4 = new Temperature();
            $temp4->setValeur($modele->temp4);
            $temp4->setDateControle(new \DateTime());
            $temp4->setEditeur($modele->editeur);
            $materiel4 = $materielRepository->findOneBy(['nom' => 'Congélateur n°2']);
            $materiel4->addTemperature($temp4);

            $entityManager->persist($materiel1);
            $entityManager->persist($materiel2);
            $entityManager->persist($materiel3);
            $entityManager->persist($materiel4);

            $entityManager->flush();

            if ($temp1->getValeur() > $materiel1->getTempMax()
                or $temp2->getValeur() > $materiel2->getTempMax()
                or $temp3->getValeur() < $materiel3->getTempMax()
                or $temp4->getValeur() < $materiel4->getTempMax())
            {
                $this->addFlash('warning', 'Attention le seuil de température dépasse les limites de l\'appareil !');
            }

            $this->addFlash('success', 'Températures enregistrées avec succès !');
            return $this->redirectToRoute('app_temperature_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/new.html.twig', [
            'form' => $form->createView(),
            'frigo1' => $frigo1,
            'frigo2' => $frigo2,
            'congelateur1' => $congelateur1,
            'congelateur2' => $congelateur2,
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
    public function stats(TemperatureRepository $temperatureRepository, int $id, ?Materiel $materiel, MaterielRepository $materielRepository): Response
    {
        $temperatures = $temperatureRepository->findBy(['materiel' => $id], ['dateControle' => 'ASC']);

        $materiels = $materielRepository->findAll();

        $dataDate = [];
        $dataValeur = [];

        foreach ($temperatures as $temperature)
        {
            $dataDate[] = $temperature->getDateControle()->format('d-m-Y');
            $dataValeur[] = $temperature->getValeur();
        }


        return $this->render('temperature/stats.html.twig', [
            'dataDate' => json_encode($dataDate),
            'dataValeur' => json_encode($dataValeur),
            'id' => $id,
            'materiels' => $materiels
        ]);
    }

}
