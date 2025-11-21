<?php
// src/Controller/JeuxController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
require_once 'modele/class.PdoJeux.inc.php';
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use PdoJeux;

class JeuxController extends AbstractController
{
    /**
     * fonction pour afficher la liste des jeux
     * @param $db
     * @param $refJeuModif positionné si demande de modification
     * @param $refJeuNotif positionné si mise à jour dans la vue
     * @param $notification pour notifier la mise à jour dans la vue
     */
    private function afficherJeux(
        PdoJeux $db,
        string $refJeuModif,
        string $refJeuNotif,
        string $notification
    ) {
        $tbJeux = $db->getLesJeux();
        $tbMarques = $db->getLesMarques();
        $tbGenres = $db->getLesGenres();
        $tbPlateformes = $db->getLesPlateformes();
        $tbPegis = $db->getLesPegis();
        
        return $this->render('lesJeux.html.twig', array(
            'menuActif' => 'Jeux',
            'tbJeux' => $tbJeux,
            'tbMarques' => $tbMarques,
            'tbGenres' => $tbGenres,
            'tbPlateformes' => $tbPlateformes,
            'tbPegis' => $tbPegis,
            'refJeuModif' => $refJeuModif,
            'refJeuNotif' => $refJeuNotif,
            'notification' => $notification
        ));
    }

    #[Route('/jeux', name: 'jeux_afficher')]
    public function index(SessionInterface $session)
    {
        $db = PdoJeux::getPdoJeux();
        return $this->afficherJeux($db, '', '', 'rien');
    }

    #[Route('/jeux/ajouter', name: 'jeux_ajouter')]
    public function ajouter(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $refJeuNotif = '';
        $notification = 'rien';
        $prix = floatval($request->request->get('txtPrixJeu'));
        
        if (!empty($request->request->get('txtRefJeu')) && 
            !empty($request->request->get('txtNomJeu'))) {
            try {
                $db->ajouterJeu(
                    $request->request->get('txtRefJeu'),
                    $request->request->get('txtNomJeu'),
                    $request->request->get('lstMarque'),
                    $request->request->get('lstGenre'),
                    $request->request->get('lstPlateforme'),
                    $request->request->get('lstPegi'),
                    $request->request->get('txtPrixJeu'),
                    $request->request->get('txtDateParutionJeu')
                );
                $refJeuNotif = $request->request->get('txtRefJeu');
                $notification = 'Ajouté';
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->afficherJeux($db, '', $refJeuNotif, $notification);
    }

    #[Route('/jeux/demandermodifier', name: 'jeux_demandermodifier')]
    public function demanderModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        return $this->afficherJeux(
            $db,
            $request->request->get('txtRefJeu'),
            '',
            'rien'
        );
    }

    #[Route('/jeux/validermodifier', name: 'jeux_validermodifier')]
    public function validerModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        
        // Récupérer et formater les données du formulaire
        $refJeu = $request->request->get('txtRefJeu');
        $nom = $request->request->get('txtNomJeu');
        $marque = $request->request->get('lstMarque');
        $genre = $request->request->get('lstGenre');
        $plateforme = $request->request->get('lstPlateforme');
        $idPegi = $db->getIdPegiFromAgeLimite($request->request->get('lstPegi'));
        
        // Convertir le prix en float
        $prix = floatval($request->request->get('txtPrixJeu'));
        
        // Récupérer la date
        $dateParution = $request->request->get('txtDateParutionJeu');

        try {
            $db->modifierJeu(
                $refJeu,
                $nom,
                $marque,
                $genre,
                $plateforme,
                $idPegi,
                $prix,
                $dateParution
            );
            
            return $this->afficherJeux(
                $db,
                '',
                $refJeu,
                'Modifié'
            );
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->afficherJeux($db, '', '', 'rien');
        }
    }

    #[Route('/jeux/supprimer', name: 'jeux_supprimer')]
    public function supprimer(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();

        $db->supprimerJeu($request->request->get('txtRefJeu'));
        $this->addFlash(
            'success',
            'Le jeu a été supprimé'
        );
        return $this->afficherJeux($db, '', '', 'rien');
    }
}