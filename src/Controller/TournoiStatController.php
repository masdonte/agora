<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;
use App\Repository\CatTournoisRepository;
class TournoiStatController extends AbstractController
{
    #[Route('/statTournoi', name: 'app_stat_tournoi_index')]
    public function index(
        Request $request,
        TournoiRepository $tournoiRepository,
        CatTournoisRepository $categorieRepository
    ): Response {
        $categorieId = $request->query->get('categorie');
        if ($categorieId) {
            $tournois = $tournoiRepository->findBy(['categorie' => $categorieId]);
        } else {
            $tournois = $tournoiRepository->findAll();
        }
        $stats = [];
        foreach ($tournois as $tournoi) {
            $stats[] = [
                'libelle' => $tournoi->getLibelle(),
                'categorie' => $tournoi->getCategorie()->getLibelle(),
                'nbParticipants' => count($tournoi->getParticipants())
            ];
        }
        $categories = $categorieRepository->findAll();
        return $this->render('tournoi_stat/index.html.twig', [
            'stats' => $stats,
            'categories' => $categories,
            'selectedCategorie' => $categorieId,
            'menuActif' => 'Tournois',
        ]);
    }
}