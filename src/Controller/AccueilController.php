<?php
/**
 * Contrôleur de la page d'accueil
 * 
 * Ce contrôleur gère :
 * - L'affichage de la page d'accueil pour les utilisateurs connectés
 * - La redirection vers la page de connexion pour les utilisateurs non connectés
 *
 * @package App\Controller
 * @author Original
 * @version 1.0
 */

namespace App\Controller;

// Dépendances
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccueilController extends AbstractController
{
    /**
     * Page d'accueil de l'application
     * 
     * @Route("/", name="accueil")
     * @param SessionInterface $session Interface de gestion de session
     * @return Response Vue appropriée selon l'état de connexion
     */
    #[Route('/', name: 'accueil')]
    public function index(SessionInterface $session): Response
    {
        // Vérification de l'état de connexion de l'utilisateur
        // Priorité au système Symfony Security
        if ($this->getUser()) {
            // Utilisateur connecté via Symfony Security : affichage de la page d'accueil
            return $this->render('accueil.html.twig', [
                'menuActif' => 'Accueil',
            ]);
        } elseif ($session->has('idUtilisateur')) {
            // Utilisateur connecté via l'ancien système de session : affichage de la page d'accueil
            return $this->render('accueil.html.twig', [
                'menuActif' => 'Accueil',
            ]);
        } else {
            // Utilisateur non connecté : redirection vers la page de connexion Symfony
            return $this->redirectToRoute('app_login');
        }
    }
}
?>
