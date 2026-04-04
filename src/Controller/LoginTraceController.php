<?php

namespace App\Controller;

use App\Entity\LoginTrace;
use App\Form\LoginTraceType;
use App\Repository\LoginTraceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/login/trace')]
final class LoginTraceController extends AbstractController
{
    #[Route(name: 'app_login_trace_index', methods: ['GET'])]
    public function index(LoginTraceRepository $loginTraceRepository): Response
    {
        return $this->render('login_trace/index.html.twig', [
            'login_traces' => $loginTraceRepository->findAllOrderedByDateDesc(),
            'menuActif' => 'Membres',
        ]);
    }

    #[Route('/new', name: 'app_login_trace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $loginTrace = new LoginTrace();
        $form = $this->createForm(LoginTraceType::class, $loginTrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($loginTrace);
            $entityManager->flush();

            return $this->redirectToRoute('app_login_trace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_trace/new.html.twig', [
            'login_trace' => $loginTrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_login_trace_show', methods: ['GET'])]
    public function show(LoginTrace $loginTrace): Response
    {
        return $this->render('login_trace/show.html.twig', [
            'login_trace' => $loginTrace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_login_trace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LoginTrace $loginTrace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoginTraceType::class, $loginTrace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_login_trace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_trace/edit.html.twig', [
            'login_trace' => $loginTrace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_login_trace_delete', methods: ['POST'])]
    public function delete(Request $request, LoginTrace $loginTrace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $loginTrace->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($loginTrace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login_trace_index', [], Response::HTTP_SEE_OTHER);
    }
}
