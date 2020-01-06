<?php


namespace App\Controller;


use App\Entity\Stage;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends  AbstractController
{

    private const CURRENT_MENU = "stage";
    /**
     * @var StageRepository
     */
    private $repo;

    public function __construct(StageRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/stages", name="stage.index")
     */
    public function index(): Response
    {
        $stages = $this->repo->findAll();
        return $this->render("stage/index.html.twig", [
            "current_menu" => self::CURRENT_MENU,
            "stages" => $stages
        ]);
    }

    /**
     * @Route("/stages/{slug}-{id}", name="stage.show", requirements={"slug": "[a-z0-9\-]*"}))
     * @param int $id
     * @return Response
     */
    public function show(Stage $stage){
        return $this->render("stage/show.html.twig", [
            "current_menu" => self::CURRENT_MENU,
            "stage" => $stage
        ]);
    }

}