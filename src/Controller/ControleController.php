<?php

namespace App\Controller;

use App\Entity\Controle;
use App\Entity\Document;
use App\Form\ControleType;
use App\Repository\ControleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/controle')]
class ControleController extends AbstractController
{
    #[Route('/', name: 'app_controle_index', methods: ['GET'])]
    public function index(ControleRepository $controleRepository): Response
    {
        return $this->render('controle/index.html.twig', [
            'controles' => $controleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_controle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $controle = new Controle();
        $form = $this->createForm(ControleType::class, $controle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $documents = $form->get('documents')->getData();
            $size = count($documents);

            if (!$documents && ($size === 0))
            {
                $this->addFlash('warning', 'Pièce jointe obligatoire');
            } else {
                if ($documents) {
                    foreach ($documents as $document)
                    {
                        $filename = uniqid() . '.' . $document->guessExtension();
                        $document->move($this->getParameter('documents_directory'), $filename);

                        $document = new Document();
                        $document->setNomStockage($filename);
                        $controle->addDocument($document);
                    }
                }
                $entityManager->persist($controle);
                $entityManager->flush();

                $this->addFlash('success', 'Contrôle Labocéa enregistré avec succès !');
                return $this->redirectToRoute('app_controle_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('controle/new.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_controle_show', methods: ['GET'])]
    public function show(Controle $controle): Response
    {
        return $this->render('controle/show.html.twig', [
            'controle' => $controle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_controle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Controle $controle, ControleRepository $controleRepository): Response
    {
        $form = $this->createForm(ControleType::class, $controle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $documents = $form->get('documents')->getData();

            foreach ($documents as $document)
            {
                $filename = uniqid() . '.' . $document->guessExtension();
                $document->move($this->getParameter('documents_directory'), $filename);

                $document = new Document();
                $document->setNomStockage($filename);
                $controle->addDocument($document);
            }

            $controleRepository->save($controle, true);

            return $this->redirectToRoute('app_controle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('controle/edit.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_controle_delete', methods: ['POST'])]
    public function delete(Request $request, Controle $controle, ControleRepository $controleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$controle->getId(), $request->request->get('_token'))) {
            $controleRepository->remove($controle, true);
        }

        return $this->redirectToRoute('app_controle_index', [], Response::HTTP_SEE_OTHER);
    }
}
