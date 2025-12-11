<?php

namespace App\Controller;

use App\Entity\CatTournois;
use App\Form\CatTournoisType;
use App\Repository\CatTournoisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cat/tournois')]
final class CatTournoisController extends AbstractController
{
    #[Route(name: 'app_cat_tournois_index', methods: ['GET'])]
    public function index(CatTournoisRepository $catTournoisRepository): Response
    {
        return $this->render('cat_tournois/index.html.twig', [
            'cat_tournois' => $catTournoisRepository->findAll(),
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/new', name: 'app_cat_tournois_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $catTournoi = new CatTournois();
        $form = $this->createForm(CatTournoisType::class, $catTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les tournois sélectionnés
            $selectedTournois = $form->get('tournois')->getData();
            
            // Mettre à jour la catégorie pour chaque tournoi sélectionné
            if ($selectedTournois) {
                foreach ($selectedTournois as $tournoi) {
                    $tournoi->setCategorie($catTournoi);
                }
            }
            
            $entityManager->persist($catTournoi);
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_tournois/new.html.twig', [
            'cat_tournoi' => $catTournoi,
            'form' => $form,
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}', name: 'app_cat_tournois_show', methods: ['GET'])]
    public function show(CatTournois $catTournoi): Response
    {
        return $this->render('cat_tournois/show.html.twig', [
            'cat_tournoi' => $catTournoi,
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cat_tournois_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CatTournois $catTournoi, EntityManagerInterface $entityManager): Response
    {
        // Sauvegarder les tournois actuels de la catégorie avant la modification
        $originalTournois = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($catTournoi->getTournois() as $tournoi) {
            $originalTournois->add($tournoi);
        }
        
        $form = $this->createForm(CatTournoisType::class, $catTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les tournois sélectionnés dans le formulaire
            $selectedTournois = $form->get('tournois')->getData() ?? [];
            
            // Convertir en ArrayCollection si ce n'est pas déjà le cas
            if (!($selectedTournois instanceof \Doctrine\Common\Collections\Collection)) {
                $selectedTournoisCollection = new \Doctrine\Common\Collections\ArrayCollection($selectedTournois);
            } else {
                $selectedTournoisCollection = $selectedTournois;
            }
            
            // Retirer la catégorie des tournois qui ne sont plus sélectionnés
            foreach ($originalTournois as $tournoi) {
                if (!$selectedTournoisCollection->contains($tournoi)) {
                    $tournoi->setCategorie(null);
                }
            }
            
            // Ajouter la catégorie aux nouveaux tournois sélectionnés
            foreach ($selectedTournoisCollection as $tournoi) {
                $tournoi->setCategorie($catTournoi);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_tournois/edit.html.twig', [
            'cat_tournoi' => $catTournoi,
            'form' => $form,
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}', name: 'app_cat_tournois_delete', methods: ['POST'])]
    public function delete(Request $request, CatTournois $catTournoi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catTournoi->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($catTournoi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cat_tournois_index', [], Response::HTTP_SEE_OTHER);
    }
}
