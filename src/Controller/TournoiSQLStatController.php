<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;

class TournoiSQLStatController extends AbstractController
{
    #[Route('/statSql', name: 'app_stat_sql_tournoi')]
    public function indexSQL(
        Request $request,
        TournoiRepository $tournoiRepository
    ): Response {
        // On récupère une date passée en GET ou on met une valeur par défaut
        $datemax = $request->query->get('datemax', '2025-01-01');
        // Appel à la méthode SQL du repository
        $tournois = $tournoiRepository->findAllAfterThanDateSQL($datemax);
        // Transformation du résultat SQL brut en tableau exploitable
        $stats = [];
        foreach ($tournois as $t) {
            $stats[] = [
                'libelle' => $t[1] ?? '(non défini)', // dépend de l’ordre des colonnes
                'categorie' => $t[2] ?? '(catégorie inconnue)',
                'date' => $t[3] ?? '(pas de date)',
            ];
        }
        return $this->render('tournoi_stat/sql.html.twig', [
            'stats' => $stats,
            'datemax' => $datemax,
            'mode' => 'SQL',
            'menuActif' => 'Tournois',
        ]);
    }
}