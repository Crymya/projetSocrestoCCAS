<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Entity\ListeDesTaches;
use App\Entity\TacheRealise;
use App\Form\TacheRealiseType;
use App\Form\TacheRType;
use App\Repository\ListeDesTachesRepository;
use App\Repository\TacheRealiseRepository;
use App\Tools\ModeleTache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tache')]
class TacheController extends AbstractController
{

    #[Route('/', name: 'app_tache_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('tache/index.html.twig');
    }

    #[Route('/list', name: 'app_tache_list', methods: ['GET'])]
    public function list(TacheRealiseRepository $tacheRealiseRepository): Response
    {
        return $this->render('tache/list.html.twig', [
            'tache_realises' => $tacheRealiseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListeDesTachesRepository $tachesRepository, EntityManagerInterface $entityManager): Response
    {
        $tache = new TacheRealise();
        $form = $this->createForm(TacheRealiseType::class, $tache);
        $form->handleRequest($request);

        $taches = $tachesRepository->findByZone(['id' => 3]);

        if ($form->isSubmitted() && $form->isValid())
        {
            $tache->setMoment(new \DateTime());

            $entityManager->persist($tache);
            $entityManager->flush();

            $this->addFlash('success', 'Tâche sauvegardée avec succès !');
            return $this->redirectToRoute('app_tache_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/new.html.twig', [
            'taches' => $taches,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_tache_show', methods: ['GET'])]
    public function show(TacheRealise $tacheRealise): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache_realise' => $tacheRealise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TacheRealise $tacheRealise, TacheRealiseRepository $tacheRealiseRepository): Response
    {
        $form = $this->createForm(TacheRealiseType::class, $tacheRealise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tacheRealiseRepository->save($tacheRealise, true);

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/edit.html.twig', [
            'tache_realise' => $tacheRealise,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_tache_delete', methods: ['POST'])]
    public function delete(Request $request, TacheRealise $tacheRealise, TacheRealiseRepository $tacheRealiseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tacheRealise->getId(), $request->request->get('_token'))) {
            $tacheRealiseRepository->remove($tacheRealise, true);
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }
}
