<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Document;
use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Form\SearchDocumentType;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livraison')]
class LivraisonController extends AbstractController
{
    #[Route('/', name: 'app_livraison_index', methods: ['GET'])]
    public function index(Request $request, LivraisonRepository $livraisonRepository): Response
    {
        // partie recheche selon date début et date fin
        $data = new SearchData();
        $form =$this->createForm(SearchDocumentType::class, $data);
        $form->handleRequest($request);

        return $this->render('livraison/index.html.twig', [
            'livraisons' => $livraisonRepository->findSearchByDate($data),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Nouvelle instance de livraison et création du formulaire
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);
        // Submit et validation du formulaire
        if ($form->isSubmitted() && $form->isValid())
        {
            // On récupère les données de l'entrée 'documents', soit les images
            $documents = $form->get('documents')->getData();
            $size = count($documents);
            // On vérifie qu'il y a bien un document, sinon message d'alerte
            if (!$documents && ($size === 0))
            {
                $this->addFlash('warning', 'Document obligatoire');
            } else {
                // Sinon s'il y a bien une image, on boucle dessus, on crée un nom unique
                if ($documents) {
                    foreach ($documents as $document)
                    {
                        $filename = uniqid() . '.' . $document->guessExtension();
                        // On bouge le document dans le répertoire définit dans le fichier de config
                        $document->move($this->getParameter('documents_directory'), $filename);
                        // On créé une nouvelle instance de document, on lui affecte le nom
                        $document = new Document();
                        $document->setNomStockage($filename);
                        // On ajoute le document à la livraison
                        $livraison->addDocument($document);
                    }
                }
                // On persiste et on flush en BDD (que le nom qui est conservé en BDD)
                $entityManager->persist($livraison);
                $entityManager->flush();
                // Message de succès
                $this->addFlash('success', 'Bon de livraison ajouté avec succès !');
                return $this->redirectToRoute('app_livraison_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {
        // Code similaire à la création d'un bon de livraison sauf qu'ici on mmodifie la saisie.
        $form = $this->createForm(LivraisonType::class, $livraison);
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
                $livraison->addDocument($document);
            }
            // On save en BDD
            $livraisonRepository->save($livraison, true);
            // On redirige
            return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_livraison_delete', methods: ['POST'])]
    public function delete(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraison->getId(), $request->request->get('_token'))) {
            $livraisonRepository->remove($livraison, true);
        }

        return $this->redirectToRoute('app_livraison_index', [], Response::HTTP_SEE_OTHER);
    }
}
