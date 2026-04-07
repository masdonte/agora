<?php

namespace App\Controller;

use App\Entity\Reconnaissance;
use App\Form\ReconnaissanceType;
use App\Repository\ReconnaissanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Ce contrôleur gère les opérations CRUD pour l'entité Reconnaissance
// Les routes sont définis pour chaque action comme new; index... 

#[Route('/reconnaissance')]
final class ReconnaissanceController extends AbstractController
{
    #[Route(name: 'app_reconnaissance_index', methods: ['GET'])]
    public function index(ReconnaissanceRepository $reconnaissanceRepository): Response
    {
        // Liste toutes les reconnaissances et active le lien Reconnaissance dans le menu
        return $this->render('reconnaissance/index.html.twig', [
            'reconnaissances' => $reconnaissanceRepository->findAll(),
            'menuActif' => 'Reconnaissance',
        ]);
    }
    // La route pour créer un formulaire de reconnaissance 


    #[Route('/new', name: 'app_reconnaissance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reconnaissance = new Reconnaissance();
        $form = $this->createForm(ReconnaissanceType::class, $reconnaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reconnaissance);
            $entityManager->flush();

            return $this->redirectToRoute('app_reconnaissance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reconnaissance/new.html.twig', [
            'reconnaissance' => $reconnaissance,
            'form' => $form,
        ]);
    }
    // La route pour afficher les reconnaissances 

    #[Route('/{id}', name: 'app_reconnaissance_show', methods: ['GET'])]
    public function show(Reconnaissance $reconnaissance): Response
    {
        return $this->render('reconnaissance/show.html.twig', [
            'reconnaissance' => $reconnaissance,
        ]);
    }
    // La route pour éditer les reconnaissances et modifier les données de l'entité reconnaissance
    #[Route('/{id}/edit', name: 'app_reconnaissance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reconnaissance $reconnaissance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReconnaissanceType::class, $reconnaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reconnaissance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reconnaissance/edit.html.twig', [
            'reconnaissance' => $reconnaissance,
            'form' => $form,
        ]);
    }
    // La route pour supprimer les reconnaissances

    #[Route('/{id}', name: 'app_reconnaissance_delete', methods: ['POST'])]
    public function delete(Request $request, Reconnaissance $reconnaissance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reconnaissance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reconnaissance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reconnaissance_index', [], Response::HTTP_SEE_OTHER);
    }
}
