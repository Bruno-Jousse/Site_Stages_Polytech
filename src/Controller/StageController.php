<?php


namespace App\Controller;


use App\Entity\Search\StageSearch;
use App\Entity\Stage;
use App\Form\StageSearchType;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        $search = new StageSearch();
        $form = $this->createForm(StageSearchType::class, $search);
        $form->handleRequest($request);

        $stages = $this->repo->filtrerStages($search);
        return $this->render("stage/index.html.twig", [
            "current_menu" => self::CURRENT_MENU,
            "stages" => $stages,
            "form" => $form->createView()
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