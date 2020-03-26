<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * Affiche la page d'accueil
     *
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render("accueil/index.html.twig", [
            "current_menu" => "accueil"
        ]);
    }
}