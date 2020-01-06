<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImporterController extends AbstractController
{
    /**
     * @Route("/importer", name="importer")
     */
    public function index(): Response
    {
        return $this->render("importer/index.html.twig", [
            "current_menu" => "importer"
        ]);
    }
}