<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;
class TournoiDQLStatController extends AbstractController
{
    #[Route('/statDql', name: 'app_stat_dql_tournoi')]
    public function indexDQL(Request $request, TournoiRepository $tournoiRepository): Response
    {
        // On récupère une date passée en GET ou on met une valeur par défaut
        $datemax = $request->query->get('datemax', '2025-01-01');
        // Appel à la méthode DQL du repository
        $tournois = $tournoiRepository->findAllAfterThanDateDQL($datemax);
        // Transformation du résultat (objets Tournoi) en tableau exploitable pour la vue
        $stats = [];
        foreach ($tournois as $t) {
            $stats[] = [
                'libelle' => $t->getLibelle(),
                'categorie' => $t->getCategorie() ? $t->getCategorie()->getLibelle() : '(catégorie inconnue)',
                'date' => $t->getDate() ? $t->getDate()->format('Y-m-d') : '(pas de date)',
            ];
        }
        return $this->render('tournoi_stat/sql.html.twig', [
            'stats' => $stats,
            'datemax' => $datemax,
            'mode' => 'DQL',
            'menuActif' => 'Tournois',
        ]);
    }
}