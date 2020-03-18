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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Dotenv\Dotenv;
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

    private $envLocal;

    public function __construct(StageRepository $repo, AdresseRepository $adrRepo, EntrepriseRepository $entRepo, EntityManagerInterface $em, ParameterBagInterface $params)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->entRepo = $entRepo;
        $this->adrRepo = $adrRepo;
        $this->envLocal = $params->get("projectDir") . "/.env.local";
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
                if($this->saveCSV($file))
                    $this->addFlash("success", "Informations importées avec succès !");
                else
                    $this->addFlash("error", "Erreur lors de l'importation du fichier");
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
            return false;
        }

        $dotenv = new Dotenv();
        $dotenv->load($this->envLocal);
        $apiKey = $_ENV["GEOCODE_API_KEY"];

        try {
            $sheet = $spreadsheet->getSheet(0);
        } catch (PhpSpreadsheet\Exception $e) {
            return false;
        }
        $rows = $sheet->toArray();

        $adressesGps = [];

        foreach($rows as $key => $data) {
            if(!$header){
                $header = $data;
            }
            else {
                $row = array_combine($header, $data);
                $adressesGps[$key] = array(
                    "street" => $row["adresse"],
                    "city" => $row["ville"],
                    "country" => $row["Pays"],
                    "postalCode" => $row["codepostal"]
                );
            }
        }

        $gpss = $this->getGPSCoordinates($adressesGps, $apiKey);

        $header = NULL;
        foreach($rows as $key => $data){
            if(!$header){
                $header = $data;
            }
            else{
                $row = array_combine($header, $data);
                $nomEtud = $row["nom_user"];
                $prenomEtud = $row["prenom_user"];
                $promo = (int) $row["nom_promo"];
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
                $annee = (int) $row["Nom_Periode"];
                $sujet = $row["sujet"];
                $intitule = $row["intitule"];
                $nom_tuteur_ent = $row["Nom"];
                $prenom_tuteur_ent = $row["prenom"];
                $mail = $row["mail"];
                $tel = $row["tel_prof"];
                $gratification = (float) $row["Gratification_Mensuelle"];

                if(!isset($gpss[$key])){
                    $lat = "Not defined";
                    $lon = "Not defined";
                }
                else{
                    $lat = $gpss[$key]["lat"];
                    $lon = $gpss[$key]["lon"];
                }

                //Not used
                $civilite = $row["nom_civilite"];
                $option = $row["Option"];
                $civilite_tuteur_ent = $row["nom_civilite1"];
                $nom_tuteur_ent2 = $row["Nom1"];
                $prenom_tuteur_ent2 = $row["prenom1"];
                $civilite_tuteur_ent2 = $row["nom_civilite2"];
                $mail2 = $row["mail1"];
                $tel2 = $row["tel_prof1"];
                $theme = $row["theme"];

                //Manque:
                //Intitulé (vide)
                //Mail visible ou non
                //Lien vers les transparants
                //Entreprise privée ou publique
                //Stage a mené à une embauche
                //Continent
                //Commentaire étudiant
                //Thèmes (vide)
                //Mots clés

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
                    ->setLatitude($lat)
                    ->setLongitude($lon)
                    ->setVille($ville);

                if( ($adr = $this->adrRepo->findAdresse($adresse)) ){
                    $adresse = $adr;
                }

                $date1 = date_create_from_format("d/m/Y", $date_deb);
                $date2 = date_create_from_format("d/m/Y", $date_fin);

                if(!$date1 || !$date2){
                    $nbJours = -1;
                }
                else{
                    $nbJours = ($date1->diff($date2))->format("%a");
                }

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

        return true;
    }

    private function getGPSCoordinates($adresses, $apiKey){
        $gpss = [];
        $url = "http://open.mapquestapi.com/geocoding/v1/batch?key=". $apiKey;
        $post = array();
        $keys = [];

        foreach ($adresses as $key => $adresse){
            //Ce tableau garde en mémoire les clés pour pouvoir par la suite associé la bonne coordonnées à la bonne adresse
            $keys[$adresse["street"].$adresse["city"].$adresse["country"]] = $key;
            $gpss[$key]["lat"] = "Not defined";
            $gpss[$key]["lon"] = "Not defined";
        }

        $post = array_values($adresses);
        $postValues["locations"] = $post;

        //var_dump($post);
        $encodedJson = json_encode($postValues);
        //var_dump($encodedJson);

        //Initialize cURL.
        $ch = curl_init();

        //Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedJson);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($encodedJson))
        );

        //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        //Execute the request.
        $json = curl_exec($ch);

        //Close the cURL handle.
        curl_close($ch);

        //var_dump($json);

        $decodedJson = json_decode($json);

        if($decodedJson->info->statuscode === 0) {

            foreach($decodedJson->results as $result){
                $gps = [];
                $key = NULL;
                $gps["lat"] = "Not defined";
                $gps["lon"] = "Not defined";

                try{
                    //var_dump($result->providedLocation->street . $result->providedLocation->city . $result->providedLocation->country);
                    $key =  $keys[$result->providedLocation->street . $result->providedLocation->city . $result->providedLocation->country];

                    $gps["lat"] = (string) $result->locations[0]->latLng->lat;
                    $gps["lon"] = (string) $result->locations[0]->latLng->lng;
                } catch (\Exception $e){
                } finally {
                    if(isset($key))
                        $gpss[$key] = $gps;
                }
            }
        }

        //var_dump($gpss);

        return $gpss;
    }
}