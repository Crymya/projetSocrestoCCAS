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
        // On récupère l'ensemble des étiquettes (à modifier et ne récupérer qu'un certain nombre et faire une recherche)
        return $this->render('etiquette/index.html.twig', [
            'etiquettes' => $etiquetteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etiquette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création de l'instance d'une étiquette
        $etiquette = new Etiquette();
        // Création du formulaire
        $form = $this->createForm(EtiquetteType::class, $etiquette);
        $form->handleRequest($request);
        // Si formulaire est soumit et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // On récupère les infos  de 'documents' donc les images
            $documents = $form->get('documents')->getData();
            $size = count($documents);
            // On vérifie qu'il y a un document (obligatoire
            if (!$documents && ($size === 0))
            {
                $this->addFlash('warning', 'Photo obligatoire');
            } else {
                if ($documents) {
                    // S'il y a un doc, boucle dessus
                    foreach ($documents as $document)
                    {
                        // On lui donne un nom unique
                        $filename = uniqid() . '.' . $document->guessExtension();
                        // On le migre dans le répertoire définit dans dans fichier de config
                        $document->move($this->getParameter('documents_directory'), $filename);
                        // On créé une instance de document, on lui set son nom
                        $document = new Document();
                        $document->setNomStockage($filename);
                        // On l'ajout à l'instance d'étiquette
                        $etiquette->addDocument($document);
                    }
                }
                // Persist et flush de l'étiquette
                $entityManager->persist($etiquette);
                $entityManager->flush();
                // Message de réussite et redirection
                $this->addFlash('success', 'Etiquette ajoutée avec succès !');
                return $this->redirectToRoute('app_etiquette_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('etiquette/new.html.twig', [
            'etiquette' => $etiquette,
            'form' => $form->createView(),
        ]);
    }

    /*
     * Détail sur une étiquette
     */
    #[Route('/{id}', name: 'app_etiquette_show', methods: ['GET'])]
    public function show(Etiquette $etiquette): Response
    {
        return $this->render('etiquette/show.html.twig', [
            'etiquette' => $etiquette,
        ]);
    }

    /*
     * Modification d'une étiquette
     * Traitement similaire à la création, on utilise méthode save du repository pour la flush en bdd
     */
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
