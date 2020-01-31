<?php


namespace App\Controller;


use App\Entity\Adresse;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Other\FichierCSV;
use App\Form\FichierCSVType;
use App\Repository\AdresseRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet;

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
    /**
     * @var EntrepriseRepository
     */
    private $entRepo;
    /**
     * @var AdresseRepository
     */
    private $adrRepo;

    public function __construct(StageRepository $repo, AdresseRepository $adrRepo, EntrepriseRepository $entRepo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->entRepo = $entRepo;
        $this->adrRepo = $adrRepo;
    }

    /**
     * @Route("/importer", name="importer")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $csv = new FichierCSV();
        $form = $this->createForm(FichierCSVType::class, $csv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get("file")->getData();
            if($file){
                $this->saveCSV($file);
                $this->addFlash("success", "Informations importées avec succès !");
            }
        }
        return $this->render("importer/index.html.twig", [
            "current_menu" => "importer",
            "form" => $form->createView()
        ]);
    }

    private function saveCSV($file){
        $header = NULL;
        try {
            $spreadsheet = PhpSpreadsheet\IOFactory::load($file);
        } catch (PhpSpreadsheet\Reader\Exception $e) {
            return;
        }
        $sheet = $spreadsheet->getSheet(0);
        $rows = $sheet->toArray();
        foreach($rows as $data){
            if(!$header){
                $header = $data;
            }
            else{
                $row = array_combine($header, $data);
                //var_dump($row);
                $nomEtud = $row["nom_user"];
                $prenomEtud = $row["prenom_user"];
                $promo = $row["nom_promo"];
                $departement = $row["nom_formation"];
                $annee_form = $row["type_stage"];
                $date_deb = $row["datedebut"];
                $date_fin = $row["datefin"];
                $nom_entreprise = $row["nom_entreprise"];
                $adresse_str = $row["adresse"];
                $adresse_suite = $row["adresse_suite"];
                $codePostal = $row["codepostal"];
                $ville = $row["ville"];
                $pays = $row["Pays"];
                $annee = $row["Nom_Periode"];
                $sujet = $row["sujet"];
                $theme = $row["theme"];
                $intitule = $row["intitule"];
                $nom_tuteur_ent = $row["Nom"];
                $prenom_tuteur_ent = $row["prenom"];
                $mail = $row["mail"];
                $tel = $row["tel_prof"];
                $gratification = $row["Gratification_Mensuelle"];

                //Not used
                $idStage = $row["id_stage"];
                $civilite = $row["nom_civilite"];
                $option = $row["Option"];
                $civilite_tuteur_ent = $row["nom_civilite1"];
                $nom_tuteur_ent2 = $row["Nom1"];
                $prenom_tuteur_ent2 = $row["prenom1"];
                $civilite_tuteur_ent = $row["nom_civilite2"];
                $mail2 = $row["mail1"];
                $tel2 = $row["tel_prof1"];
                $id_type_stage = $row["id_typestage"];
                $id_pays = $row["id_pays"];
                $id_periode_stage = $row["id_periodestage"];
                $id_promo = $row["id_promo"];
                $id_formation = $row["id_formation"];
                $lieu_stage = $row["Lieu_stage"];
                $id_option = $row["id_option"];

                //Manque:
                //Mail visible ou non
                //Lien vers les transparants
                //Entreprise privée ou publique

                //Pas de mots clés

                //Pas de thèmes

                $entreprise = new Entreprise();
                $adresse = new Adresse();
                $stage = new Stage();

                $entreprise
                    ->setNom($nom_entreprise)
                    ->setEstPrivee(true);
                if( ($ent = $this->entRepo->findEntreprise($entreprise)) ){
                    $entreprise = $ent;
                }

                $adresse
                    ->setAdresse($adresse_str)
                    ->setAdresseSuite($adresse_suite)
                    ->setCodePostal($codePostal)
                    ->setPays($pays)
                    ->setEntreprise($entreprise)
                    ->setContinent("Not defined")
                    ->setLatitude("Not defined")
                    ->setLongitude("Not defined")
                    ->setVille($ville);
                if( ($adr = $this->adrRepo->findAdresse($adresse)) ){
                    $adresse = $adr;
                }

                $date1 = date_create_from_format("d/m/Y", $date_deb);
                $date2 = date_create_from_format("d/m/Y", $date_fin);

                $nbJours = ($date1->diff($date2))->format("%a");

                $stage
                    ->setEntreprise($entreprise)
                    ->setAdresse($adresse)
                    ->setAnnee($annee)
                    ->setAnneeForm(Stage::stringToAnneeForm($annee_form))
                    ->setEntreprise($entreprise)
                    ->setCommentaire("Not defined")
                    ->setContratPro( $annee_form == "Contra Pro" )
                    ->setEstGratifie($gratification != null && $gratification != "")
                    ->setEmbauche(0)
                    ->setDepartement(Stage::stringToDepartement($departement))
                    ->setDureeJours($nbJours)
                    ->setIntitule($intitule)
                    ->setMailVisible(true)
                    ->setMailTuteurEnt($mail)
                    ->setNomEtud($nomEtud)
                    ->setPrenomEtud($prenomEtud)
                    ->setNomTuteurEnt($nom_tuteur_ent)
                    ->setPrenomTuteurEnt($prenom_tuteur_ent)
                    ->setRecap("Not defined")
                    ->setPromo($promo)
                    ->setIntitule($intitule)
                    ->setSujet($sujet)
                    ->setTelTuteurEnt($tel);

                if($this->repo->findStage($stage) == null) {
                    $this->em->persist($stage);
                    $this->em->flush();
                }
            }
        }
    }
}