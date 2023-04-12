<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Entity\TacheRealise;
use App\Form\TacheRealiseType;
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
    public function index(TacheRealiseRepository $tacheRealiseRepository): Response
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
        $modeleTache = new ModeleTache();
        $form = $this->createForm(TacheRealiseType::class, $modeleTache);
        $form->handleRequest($request);

        /*$t1 = $tachesRepository->findOneBy(['nom' => 'Sit dolores qui.']);
        $t2 = $tachesRepository->findOneBy(['nom' => 'Quas voluptatum modi sunt iure.']);*/

        $t1 = $tachesRepository->findOneBy(['nom' => 'Illum illo qui ratione.']);
        $t2 = $tachesRepository->findOneBy(['nom' => 'Dolor cupiditate repudiandae.']);

        if ($form->isSubmitted() && $form->isValid())
        {

            $tache1 = new TacheRealise();
            $tache1->setEditeur($modeleTache->editeur1);
            $tache1->setMoment(new \DateTime());
            /*$t1 = $tachesRepository->findOneBy(['nom' => 'Sit dolores qui.']);*/
            $t1 = $tachesRepository->findOneBy(['nom' => 'Illum illo qui ratione.']);
            $t1->addTacheRealise($tache1);

            $tache2 = new TacheRealise();
            $tache2->setEditeur($modeleTache->editeur2);
            $tache2->setMoment(new \DateTime());
            /*$t2 = $tachesRepository->findOneBy(['nom' => 'Quas voluptatum modi sunt iure.']);*/
            $t2 = $tachesRepository->findOneBy(['nom' => 'Dolor cupiditate repudiandae.']);
            $t2->addTacheRealise($tache2);

            $entityManager->persist($t1);
            $entityManager->persist($t2);
            $entityManager->flush();

            $this->addFlash('success', 'Tâche sauvegardée avec succès !');
            return $this->redirectToRoute('app_tache_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/new.html.twig', [
            'tache_realise' => $modeleTache,
            't1' => $t1,
            't2' => $t2,
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
