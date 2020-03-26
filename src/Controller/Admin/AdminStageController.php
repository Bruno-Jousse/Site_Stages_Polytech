<?php


namespace App\Controller\Admin;

use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\AdresseRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStageController extends  AbstractController
{
    /**
     * @var StageRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AdresseRepository
     */
    private $adrRepo;
    /**
     * @var EntrepriseRepository
     */
    private $entRepo;

    /**
     * AdminStageController constructor.
     * @param StageRepository $repo
     * @param AdresseRepository $adrRepo
     * @param EntrepriseRepository $entRepos
     * @param EntityManagerInterface $em
     */
    public function __construct(StageRepository $repo, AdresseRepository $adrRepo, EntrepriseRepository $entRepos, EntityManagerInterface $em){
        $this->repo = $repo;
        $this->em = $em;
        $this->adrRepo = $adrRepo;
        $this->entRepo = $entRepos;
    }

    /**
     * Affiche la page d'administration des stages (tableau contenant tous les stages)
     *
     * @Route("/admin/stages", name="admin.index.stages")
     */
    public function index(): Response
    {
        $stages = $this->repo->findAll();
        return $this->render("admin/index.stages.html.twig", [
            "current_menu" => "admin",
            "current_sous_menu" => "stages",
            "stages" => $stages
        ]);
    }

    /**
     * Affiche la page de création d'un stage
     * Traite le formulaire de création une fois soumis
     *
     * @Route("/admin/stages/create", name="admin.create.stages")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //On vérifie que le stage n'existe pas déjà
            if($this->repo->findStage($stage) == null)
            {
                //On vérifie que l'entreprise n'existe pas déjà
                if( ($ent = $this->entRepo->findEntreprise($stage->getAdresse()->getEntreprise())) ){
                    $stage->getAdresse()->setEntreprise($ent);
                }
                //On vérifie que l'adresse n'existe pas déjà
                if( ($adr = $this->adrRepo->findAdresse($stage->getAdresse())) ){
                    $stage->setAdresse($adr);
                }

                $stage->setEntreprise($stage->getAdresse()->getEntreprise());
                $this->em->persist($stage);
                $this->em->flush();
                $this->addFlash("success", "Stage créé avec succès !");
                return $this->redirectToRoute("admin.index.stages");
            }
        }

        return $this->render("admin/new.stages.html.twig", [
            "stages" => $stage,
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de modification d'un stage
     * Traite le formulaire une fois soumis
     *
     * @Route("/admin/stages/{id}", name="admin.edit.stages", methods="GET|POST")
     * @param Stage $stage
     * @param Request $request
     * @return Response
     */
    public function edit(Stage $stage, Request $request): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Stage édité avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.stages.html.twig", [
            "stages" => $stage,
            "form" => $form->createView()
        ]);
    }

    /**
     * Supprime le stage de la base de données
     *
     * @Route("/admin/stages/{id}", name="admin.delete.stages", methods="DELETE")
     * @param Stage $stage
     * @return Response
     */
    public function delete(Stage $stage): Response
    {
        $this->em->remove($stage);
        $this->em->flush();
        $this->addFlash("success", "Stage supprimé avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }
}