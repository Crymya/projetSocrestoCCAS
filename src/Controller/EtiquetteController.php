<?php

namespace App\Controller;

use App\Entity\Etiquette;
use App\Form\EtiquetteType;
use App\Repository\EtiquetteRepository;
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
    public function new(Request $request, EtiquetteRepository $etiquetteRepository): Response
    {
        $etiquette = new Etiquette();
        $form = $this->createForm(EtiquetteType::class, $etiquette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etiquetteRepository->save($etiquette, true);

            return $this->redirectToRoute('app_etiquette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etiquette/new.html.twig', [
            'etiquette' => $etiquette,
            'form' => $form,
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

        if ($form->isSubmitted() && $form->isValid()) {
            $etiquetteRepository->save($etiquette, true);

            return $this->redirectToRoute('app_etiquette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etiquette/edit.html.twig', [
            'etiquette' => $etiquette,
            'form' => $form,
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
