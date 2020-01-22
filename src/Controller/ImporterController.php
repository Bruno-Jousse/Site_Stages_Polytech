<?php


namespace App\Controller;


use App\Entity\Adresse;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\FichierCSV;
use App\Form\FichierCSVType;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImporterController extends AbstractController
{
    /**
     * @var StageRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(StageRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/importer", name="importer")
     */
    public function index(Request $request): Response
    {
        $csv = new FichierCSV();
        $form = $this->createForm(FichierCSVType::class, $csv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get("file")->getData();
            if($file){
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $this->saveCSV($filename);
                $this->addFlash("success", "Informations importées avec succès !");
            }
        }
        return $this->render("importer/index.html.twig", [
            "current_menu" => "importer",
            "form" => $form->createView()
        ]);
    }

    private function saveCSV($filename){
        $f = fopen($filename, 'r');
        while( ($row = fgetcsv($f) ) ){
            $nomEtud = $row[0];
            $prenomEtud = $row[1];
            $departement = $row[3];
            $annee_form = $row[4];
            $date_deb = $row[5];
            $date_fin = $row[6];
            $nom_entreprise = $row[7];
            $adresse_str = $row[8];
            $adresse_suite = $row[9];
            $codePostal = $row[10];
            $ville = $row[11];
            $pays = $row[12];
            $sujet = $row[13];

            $entreprise = new Entreprise();
            $entreprise
                ->setNom($nom_entreprise)
                ->setEstPrivee(false);

            $adresse = new Adresse();
            $adresse
                ->setAdresse($adresse_str)
                ->setAdresseSuite($adresse_suite)
                ->setCodePostal($codePostal)
                ->setPays($pays)
                ->setEntreprise($entreprise)
                ->setContinent("Not defined")
                ->setLatitude("Not defined")
                ->setLongitude("Not defined")
                ->setVille($ville)
                ->setContinent("Not defined");

            //Pas de mots clés

            //Pas de thèmes

            $date1 = \DateTime::createFromFormat("d/m/y", $date_deb);
            $date2 = \DateTime::createFromFormat("d/m/y", $date_fin);

            $nbJours = $date1->diff($date2)["d"];

            $stage = new Stage();
            $stage
                ->setEntreprise($entreprise)
                ->setAdresse($adresse)
                ->setAnnee(0)
                ->setAnneeForm(Stage::stringToAnneeForm($annee_form))
                ->setEntreprise($entreprise)
                ->setCommentaire("Not defined")
                ->setContratPro( $annee_form == "Contra Pro" )
                ->setEstGratifie(0)
                ->setEmbauche(0)
                ->setDepartement(Stage::stringToDepartement($departement))
                ->setDureeJours($nbJours)
                ->setIntitule("Not defined")
                ->setMailVisible(false)
                ->setMailTuteurEnt("Not defined")
                ->setNomEtud($nomEtud)
                ->setPrenomEtud($prenomEtud)
                ->setNomTuteurEnt("Not defined")
                ->setPrenomTuteurEnt("Not defined")
                ->setRecap("Not defined")
                ->setPromo(0)
                ->setTelTuteurEnt("Not defined");

            $this->em->persist($stage);
            $this->em->flush();
        }
    }
}