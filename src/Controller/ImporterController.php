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

    /**
     * ImporterController constructor.
     * @param StageRepository $repo
     * @param AdresseRepository $adrRepo
     * @param EntrepriseRepository $entRepo
     * @param EntityManagerInterface $em
     * @param ParameterBagInterface $params
     */
    public function __construct(StageRepository $repo, AdresseRepository $adrRepo, EntrepriseRepository $entRepo, EntityManagerInterface $em, ParameterBagInterface $params)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->entRepo = $entRepo;
        $this->adrRepo = $adrRepo;
        //Permet de récupérer les variables d'environnement locales
        $this->envLocal = $params->get("projectDir") . "/.env.local";
    }

    /**
     * Affiche la page de d'importation de fichier csv ou xls
     * Traite le formulaire une fois qu'il est soumis
     *
     * @Route("/importer", name="importer")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $csv = new FichierCSV();
        $form = $this->createForm(FichierCSVType::class, $csv);
        $form->handleRequest($request);

        //Si un formulaire a été soumis
        if($form->isSubmitted() && $form->isValid()){
            //On récupère le fichier et on importe les données
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

    /**
     * Récupère les données dans le fichier et les enregistre dans la base de données
     *
     * @param $file
     * @return bool
     */
    private function saveCSV($file){
        $header = NULL;

        //On ouvre le document
        try {
            $spreadsheet = PhpSpreadsheet\IOFactory::load($file);
        } catch (PhpSpreadsheet\Reader\Exception $e) {
            return false;
        }

        //On récupère la clé API
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
            //S'il s'agit de la première ligne, on l'utilise pour obtenir le nom des clés du tableau car il s'agit du nom des colonnes
            if(!$header){
                $header = $data;
            }
            else {
                //On ajoute à un tableau les données géographiques pour pouvoir calculer les coordonnées GPS
                $row = array_combine($header, $data);
                $adressesGps[$key] = array(
                    "street" => $row["adresse"],
                    "city" => $row["ville"],
                    "country" => $row["Pays"],
                    "postalCode" => $row["codepostal"]
                );
            }
        }

        //Récupère les coordonnées GPS
        $gpss = $this->getGPSCoordinates($adressesGps, $apiKey);

        $header = NULL;
        foreach($rows as $key => $data){
            //S'il s'agit de la première ligne, on l'utilise pour obtenir le nom des clés du tableau car il s'agit du nom des colonnes
            if(!$header){
                $header = $data;
            }
            else{
                //On récupère toutes les données de la première ligne
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

                //On crée une entreprise avec les informations récupérées
                $entreprise
                    ->setNom($nom_entreprise)
                    ->setEstPrivee(true);
                //On vérifie que l'entreprise n'est pas déjà présente dans la base de données
                if( ($ent = $this->entRepo->findEntreprise($entreprise)) ){
                    $entreprise = $ent;
                }

                //On crée une adresse avec les informations récupérées
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
                //On vérifie que l'adresse n'est pas déjà présente dans la base de données
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

                //On crée un stage avec les informations récupérées
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
                //On vérifie que le stage n'est pas déjà présent dans la base de données
                if($this->repo->findStage($stage) == null) {
                    $this->em->persist($stage);
                    $this->em->flush();
                }
            }
        }

        return true;
    }

    /**
     * Envoie les données géographiques des différentes adresses à l'API geocoding de MapQuestAPI et récupère les coordonnées GPS de ces adresses.
     *
     * @param $adresses
     * @param $apiKey
     * @return array
     */
    private function getGPSCoordinates($adresses, $apiKey){
        $gpss = [];
        $url = "http://open.mapquestapi.com/geocoding/v1/batch?key=". $apiKey;
        $post = array();
        $keys = [];

        foreach ($adresses as $key => $adresse){
            //Ce tableau garde en mémoire les clés pour pouvoir par la suite associer les bonnes coordonnées à la bonne adresse
            $keys[$adresse["street"].$adresse["city"].$adresse["country"]] = $key;
            //Par défaut on met les coordonnées à "Not defined"
            $gpss[$key]["lat"] = "Not defined";
            $gpss[$key]["lon"] = "Not defined";
        }

        $post = array_values($adresses);
        $postValues["locations"] = $post;

        //Encode en JSON le tableau de données
        $encodedJson = json_encode($postValues);

        //Initialise le cURL.
        $ch = curl_init();

        //Définie l'url, les options et données
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedJson);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($encodedJson))
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        //Exécute la requête
        $json = curl_exec($ch);

        //Ferme le cURL
        curl_close($ch);

        //Décode le JSON reçu
        $decodedJson = json_decode($json);

        if($decodedJson->info->statuscode === 0) {

            //Pour chaque adresse, on récupère les
            foreach($decodedJson->results as $result){
                $gps = [];
                $key = NULL;
                $gps["lat"] = "Not defined";
                $gps["lon"] = "Not defined";

                try{
                    //Permet de retrouver la clé de notre tableau possédant les adresses et d'associer les bonnes coordonnées GPS à la bonne adresse
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

        return $gpss;
    }
}