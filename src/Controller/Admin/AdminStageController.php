<?php


namespace App\Controller\Admin;

use App\Entity\Stage;
use App\Form\StageType;
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

    public function __construct(StageRepository $repo, EntityManagerInterface $em){
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
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
            $stage->setEntreprise($stage->getAdresse()->getEntreprise());
            $this->em->persist($stage);
            $this->em->flush();
            $this->addFlash("success", "Stage créé avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/new.stages.html.twig", [
            "stages" => $stage,
            "form" => $form->createView()
        ]);
    }

    /**
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