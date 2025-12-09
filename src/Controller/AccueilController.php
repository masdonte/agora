<?php
// src/Controller/AccueilController.php
namespace App\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(SessionInterface $session)
    {
        // si un utilisateur est connecté on affiche la page d'accueil
        if ($this->getUser()) {
            return $this->render('accueil.html.twig');
        } else {
            // sinon on affiche la page de connexion
            return $this->render('security/login.html.twig');
        }
    }
}