<?php


namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Entreprise;
use App\Entity\MotCle;
use App\Entity\Stage;
use App\Entity\Theme;
use App\Form\AdresseType;
use App\Form\EntrepriseType;
use App\Form\MotCleType;
use App\Form\StageType;
use App\Form\ThemeType;
use App\Repository\AdresseRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\MotCleRepository;
use App\Repository\StageRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends  AbstractController
{
    /**
     * @var StageRepository
     */
    private $stageRepo;
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
     * @var MotCleRepository
     */
    private $motCleRepo;

    /**
     * @var ThemeRepository
     */
    private $themeRepo;

    /**
     * AdminController constructor.
     * @param StageRepository $stageRepo
     * @param AdresseRepository $adrRepo
     * @param EntrepriseRepository $entRepos
     * @param MotCleRepository $motCleRepo
     * @param ThemeRepository $themeRepo
     * @param EntityManagerInterface $em
     */
    public function __construct(StageRepository $stageRepo, AdresseRepository $adrRepo, EntrepriseRepository $entRepos, MotCleRepository $motCleRepo, ThemeRepository $themeRepo, EntityManagerInterface $em){
        $this->stageRepo = $stageRepo;
        $this->em = $em;
        $this->adrRepo = $adrRepo;
        $this->entRepo = $entRepos;
        $this->motCleRepo = $motCleRepo;
        $this->themeRepo = $themeRepo;
    }

    /**
     * Affiche la page d'administration des stages (tableau contenant tous les stages)
     *
     * @Route("/admin/stages", name="admin.index.stages")
     */
    public function index(): Response
    {
        /**
         * @var Stage[]
         */
        $stages = $this->stageRepo->findAll();

        /**
         * @var Adresse[]
         */
        $adresses = $this->adrRepo->findAll();

        /**
         * @var Entreprise[]
         */
        $entreprises = $this->entRepo->findAll();

        /**
         * @var MotCle[]
         */
        $motsCles = $this->motCleRepo->findAll();

        /**
         * @var Theme[]
         */
        $themes = $this->themeRepo->findAll();

        return $this->render("admin/index.stages.html.twig", [
            "current_menu" => "admin",
            "stages" => $stages,
            "adresses" => $adresses,
            "entreprises" => $entreprises,
            "motsCles" => $motsCles,
            "themes" => $themes
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
    public function createStage(Request $request): Response
    {
        $stage = new Stage();

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //On vérifie que le stage n'existe pas déjà
            if($this->stageRepo->findStage($stage) == null)
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
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de création d'une adresse
     *
     *
     * @Route("/admin/adresse/create", name="admin.create.adresse")
     * @param Request $request
     * @return Response
     */
    public function createAdresse(Request $request): Response
    {
        $adresse = new Adresse();

        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //On vérifie que l'adresse n'existe pas déjà
            if($this->adrRepo->findAdresse($adresse) == null)
            {
                $this->em->persist($adresse);
                $this->em->flush();
                $this->addFlash("success", "Adresse créée avec succès !");
                return $this->redirectToRoute("admin.index.stages");
            }
        }

        return $this->render("admin/new.adresse.html.twig", [
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de création d'une entreprise
     *
     *
     * @Route("/admin/entreprise/create", name="admin.create.entreprise")
     * @param Request $request
     * @return Response
     */
    public function createEntreprise(Request $request): Response
    {
        $entreprise = new Entreprise();

        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //On vérifie que l'entreprise n'existe pas déjà
            if($this->entRepo->findEntreprise($entreprise) == null)
            {
                $this->em->persist($entreprise);
                $this->em->flush();
                $this->addFlash("success", "Entreprise créée avec succès !");
                return $this->redirectToRoute("admin.index.stages");
            }
        }

        return $this->render("admin/new.entreprise.html.twig", [
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de création d'un mot clé
     *
     *
     * @Route("/admin/motCle/create", name="admin.create.motCle")
     * @param Request $request
     * @return Response
     */
    public function createMotCle(Request $request): Response
    {
        $motCle = new MotCle();

        $form = $this->createForm(MotCleType::class, $motCle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //On vérifie que le mot clé n'existe pas déjà
            if($this->motCleRepo->findMotCle($motCle) == null)
            {
                $this->em->persist($motCle);
                $this->em->flush();
                $this->addFlash("success", "Mot clé créé avec succès !");
                return $this->redirectToRoute("admin.index.stages");
            }
        }

        return $this->render("admin/new.motCle.html.twig", [
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de création d'un thème
     *
     *
     * @Route("/admin/theme/create", name="admin.create.theme")
     * @param Request $request
     * @return Response
     */
    public function createTheme(Request $request): Response
    {
        $theme = new Theme();

        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //On vérifie que le thème n'existe pas déjà
            if($this->themeRepo->findTheme($theme) == null)
            {
                $this->em->persist($theme);
                $this->em->flush();
                $this->addFlash("success", "Thème créé avec succès !");
                return $this->redirectToRoute("admin.index.stages");
            }
        }

        return $this->render("admin/new.theme.html.twig", [
            "current_menu" => "admin",
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
    public function editStage(Stage $stage, Request $request): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Stage modifié avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.stages.html.twig", [
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de modification d'une adresse
     * Traite le formulaire une fois soumis
     *
     * @Route("/admin/adresse/{id}", name="admin.edit.adresse", methods="GET|POST")
     * @param Adresse $adresse
     * @param Request $request
     * @return Response
     */
    public function editAdresse(Adresse $adresse, Request $request): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Adresse modifiée avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.adresse.html.twig", [
            "adresse" => $adresse,
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de modification d'une entreprise
     * Traite le formulaire une fois soumis
     *
     * @Route("/admin/entreprise/{id}", name="admin.edit.entreprise", methods="GET|POST")
     * @param Entreprise $entreprise
     * @param Request $request
     * @return Response
     */
    public function editEntreprise(Entreprise $entreprise, Request $request): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Entreprise modifiée avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.entreprise.html.twig", [
            "entreprise" => $entreprise,
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de modification d'un mot clé
     * Traite le formulaire une fois soumis
     *
     * @Route("/admin/motCle/{id}", name="admin.edit.motCle", methods="GET|POST")
     * @param MotCle $motCle
     * @param Request $request
     * @return Response
     */
    public function editMotCle(MotCle $motCle, Request $request): Response
    {
        $form = $this->createForm(MotCleType::class, $motCle );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Mot clé modifié avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.motCle.html.twig", [
            "motCle" => $motCle,
            "current_menu" => "admin",
            "form" => $form->createView()
        ]);
    }

    /**
     * Affiche la page de modification d'un thème
     * Traite le formulaire une fois soumis
     *
     * @Route("/admin/theme/{id}", name="admin.edit.theme", methods="GET|POST")
     * @param Theme $theme
     * @param Request $request
     * @return Response
     */
    public function editTheme(Theme $theme, Request $request): Response
    {
        $form = $this->createForm(ThemeType::class, $theme );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Thème modifié avec succès !");
            return $this->redirectToRoute("admin.index.stages");
        }

        return $this->render("admin/edit.theme.html.twig", [
            "theme" => $theme,
            "current_menu" => "admin",
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
    public function deleteStage(Stage $stage): Response
    {
        $this->em->remove($stage);
        $this->em->flush();
        $this->addFlash("success", "Stage supprimé avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }

    /**
     * Supprime l'adresse de la base de données
     *
     * @Route("/admin/adresse/{id}", name="admin.delete.adresse", methods="DELETE")
     * @param Adresse $adresse
     * @return Response
     */
    public function deleteAdresse(Adresse $adresse): Response
    {
        $this->em->remove($adresse);
        $this->em->flush();
        $this->addFlash("success", "Adresse supprimée avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }

    /**
     * Supprime l'entreprise de la base de données
     *
     * @Route("/admin/entreprise/{id}", name="admin.delete.entreprise", methods="DELETE")
     * @param Entreprise $entreprise
     * @return Response
     */
    public function deleteEntreprise(Entreprise $entreprise): Response
    {
        $this->em->remove($entreprise);
        $this->em->flush();
        $this->addFlash("success", "Entreprise supprimée avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }

    /**
     * Supprime le mot clé de la base de données
     *
     * @Route("/admin/motCle/{id}", name="admin.delete.motCle", methods="DELETE")
     * @param MotCle $motCle
     * @return Response
     */
    public function deleteMotCle(MotCle $motCle): Response
    {
        $this->em->remove($motCle);
        $this->em->flush();
        $this->addFlash("success", "Mot clé supprimé avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }

    /**
     * Supprime l'entreprise de la base de données
     *
     * @Route("/admin/theme/{id}", name="admin.delete.theme", methods="DELETE")
     * @param Theme $theme
     * @return Response
     */
    public function deleteTheme(Theme $theme): Response
    {
        $this->em->remove($theme);
        $this->em->flush();
        $this->addFlash("success", "Thème supprimé avec succès !");
        return $this->redirectToRoute("admin.index.stages");
    }


}