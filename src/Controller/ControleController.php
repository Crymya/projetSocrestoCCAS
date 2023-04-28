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
    /*
     * Listing des contrôles Labocéa
     * A revoir pour limiter l'affichage
     */
    #[Route('/', name: 'app_controle_index', methods: ['GET'])]
    public function index(ControleRepository $controleRepository): Response
    {
        return $this->render('controle/index.html.twig', [
            'controles' => $controleRepository->findAll(),
        ]);
    }

    /*
     * Création du contrôle
     */
    #[Route('/new', name: 'app_controle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Nouvelle instance de Controle
        $controle = new Controle();
        // Création du formulaire
        $form = $this->createForm(ControleType::class, $controle);
        $form->handleRequest($request);
        // Si formulaire saisit et validé on fait le traitement
        if ($form->isSubmitted() && $form->isValid())
        {
            // On récupère ce qui a été transmis dans l'input 'documents'
            $documents = $form->get('documents')->getData();
            $size = count($documents);
            // On vérifie s'il y a bien un document (obligatoire)
            if (!$documents && ($size === 0))
            {
                $this->addFlash('warning', 'Pièce jointe obligatoire');
            } else {
                if ($documents) {
                    // On boucle dessus si le document existe
                    foreach ($documents as $document)
                    {
                        // Nom unique
                        $filename = uniqid() . '.' . $document->guessExtension();
                        // On le déplace à l'emplacement dédié et configuré dans les fichiers de config
                        $document->move($this->getParameter('documents_directory'), $filename);
                        // Nouvelle instance de document, on lui affecte le nouveau nom unique
                        $document = new Document();
                        $document->setNomStockage($filename);
                        // On l'ajoute à l'instance de controle
                        $controle->addDocument($document);
                    }
                }
                // On persiste et on flush en bdd
                $entityManager->persist($controle);
                $entityManager->flush();
                // Message de réussite
                $this->addFlash('success', 'Contrôle Labocéa enregistré avec succès !');
                return $this->redirectToRoute('app_controle_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('controle/new.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);
    }

    /*
     * Modification du controle
     * Traitement similaire à la création du contrôle
     */
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
