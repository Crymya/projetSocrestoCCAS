<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Etiquette;
use App\Form\EtiquetteType;
use App\Repository\EtiquetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etiquette')]
class EtiquetteController extends AbstractController
{
    #[Route('/', name: 'app_etiquette_index', methods: ['GET'])]
    public function index(EtiquetteRepository $etiquetteRepository): Response
    {
        return $this->render('etiquette/index.html.twig', [
            'etiquettes' => $etiquetteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etiquette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etiquette = new Etiquette();
        $form = $this->createForm(EtiquetteType::class, $etiquette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $documents = $form->get('documents')->getData();
            $size = count($documents);

            if (!$documents && ($size === 0))
            {
                $this->addFlash('warning', 'Photo obligatoire');
            } else {
                if ($documents) {
                    foreach ($documents as $document)
                    {
                        $filename = uniqid() . '.' . $document->guessExtension();
                        $document->move($this->getParameter('documents_directory'), $filename);

                        $document = new Document();
                        $document->setNomStockage($filename);
                        $etiquette->addDocument($document);
                    }
                }
                $entityManager->persist($etiquette);
                $entityManager->flush();

                $this->addFlash('success', 'Etiquette ajoutée avec succès !');
                return $this->redirectToRoute('app_etiquette_new', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->render('etiquette/new.html.twig', [
            'etiquette' => $etiquette,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_etiquette_show', methods: ['GET'])]
    public function show(Etiquette $etiquette): Response
    {
        return $this->render('etiquette/show.html.twig', [
            'etiquette' => $etiquette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etiquette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etiquette $etiquette, EtiquetteRepository $etiquetteRepository): Response
    {
        $form = $this->createForm(EtiquetteType::class, $etiquette);
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
                $etiquette->addDocument($document);
            }

            $etiquetteRepository->save($etiquette, true);

            return $this->redirectToRoute('app_etiquette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etiquette/edit.html.twig', [
            'etiquette' => $etiquette,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_etiquette_delete', methods: ['POST'])]
    public function delete(Request $request, Etiquette $etiquette, EtiquetteRepository $etiquetteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etiquette->getId(), $request->request->get('_token'))) {
            $etiquetteRepository->remove($etiquette, true);
        }

        return $this->redirectToRoute('app_etiquette_index', [], Response::HTTP_SEE_OTHER);
    }
}
