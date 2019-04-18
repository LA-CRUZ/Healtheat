<?php

namespace App\Controller;

use DateTime;
use App\Entity\Poids;

use App\Entity\Recette;
use App\Entity\Programmes;
use App\Entity\ProgContenu;
use App\Form\InfoPersoType;
use App\Entity\TempsEffortPhy;
use App\Repository\RecetteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\InfoUserRepository;
use App\Repository\IngredientRepository;

class HealtheatController extends AbstractController
{
    /**
     * @Route("/", name="healtheat")
     * 
     * Envoie à la vue les dates des dernières rentrée de poids et de temps d'activité physique,
     * ainsi que le programme en cours
     *
     * @param InfoUserRepository $repo
     * @return void
     */
    public function index(InfoUserRepository $repo)
    {
        $date = new DateTime();

        if($this->getUser() != NULL){
            $InfoUser = $repo->find($this->getUser()->getId());
            if($InfoUser->getProgrammes()->last() != false){
                $programme = $InfoUser->getProgrammes()->last();
            } else {
                $programme = NULL;
            }

            if($InfoUser->getTempsActivitePhysique()->last() != false){
                $datetemps = $InfoUser->getTempsActivitePhysique()->last()->getDate()->diff($date);
            } else {
                $datetemps = NULL;
            }

            if($InfoUser->getPoids()->last() != false){
                $datepoids = $InfoUser->getPoids()->last()->getDate()->diff($date);
            } else {
                $datepoids = NULL;
            }
        } else {
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        return $this->render('healtheat/index.html.twig', [
            'programme' => $programme,
            'dateTemps' => $datetemps,
            'datePoids' => $datepoids,
        ]);
    }

    /**
     * @Route("/perso", name="espace_perso")
     * 
     * Envoie les informations personnelles à la vue
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function perso(Request $request, ObjectManager $manager, InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $InfoUser = $repoIU->find($this->getUser()->getId());

        $form = $this->createForm(InfoPersoType::class, $InfoUser);

        $form->handleRequest($request);

        $date = new DateTime();

        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'notice',
                'Vos changement ont été sauvegardé !'
            );

            if($InfoUser->getLPoids() != NULL){

                $newpoids = new Poids();
                $newpoids->setInfoUser($InfoUser);
                $newpoids->setPoids($InfoUser->getLPoids());
                $newpoids->setDate($date);
                $manager->persist($newpoids);
                $manager->flush();

                if($InfoUser->getTaille() != NULL){

                    $poids = $InfoUser->getLPoids();
                    $taille = $InfoUser->getTaille();
                    $taille = $taille / 100;
                    $IMC = $poids / ($taille * $taille);
                    $IMC = round($IMC,2);

                    $InfoUser->setImc($IMC);
                } else {
                    $InfoUser->setImc(NULL);
                }
            } else {
                $InfoUser->setImc(NULL);
            }
            if($InfoUser->getLTemps() != NULL){

                $newtemps = new TempsEffortPhy();
                $newtemps->setInfoUser($InfoUser);
                $newtemps->setTemps($InfoUser->getLTemps());
                $newtemps->setDate($date);
                $manager->persist($newtemps);
                $manager->flush();
            } 

            $manager->persist($InfoUser);
            $manager->flush();
            if($form->get('enregistrer')->isClicked()){
                return $this->redirectToRoute('info_perso');
            }
        }

        return $this->render('healtheat/perso.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/infoperso", name = "info_perso")
     * 
     * Envoie le formulaire d'enregistrement d'informations personnelles à la vue
     * Gère le résultat de la requete du formulaire, insère les informations dans la base de donnée 
     *
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function info_perso(InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        return $this->render('healtheat/infoperso.html.twig', [
            'info_user' => $repoIU->find($this->getUser()->getId()),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/programme", name = "mon_programme")
     * 
     * Envoie le programme en cours à la vue
     *
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function mon_programme(InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }
  
        return $this->render('healtheat/programme.html.twig', [
            'programmes' => $repoIU->find($this->getUser()->getId())->getProgrammes()->last(),
        ]);
    }


    /**
     * @Route("/generer", name="generer_programme")
     *
     * Génère un programme aléatoire sans doublon de recette et l'enregistre dans la base de donnée
     *
     * @param ObjectManager $manager
     * @param RecetteRepository $repoRecette
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function generer_programme(ObjectManager $manager, RecetteRepository $repoRecette, InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $date = new DateTime();

        $programme = new Programmes();

        $programme->setDateDebut($date);
        $programme->setUtilisateur($repoIU->find($this->getUser()->getId()));

        $doublon = array();
        $i = 0;

        while($i < 14){
            $contenu = new ProgContenu();
            $recette = new Recette();

            $recette = $repoRecette->find(rand(1, 111));

            if(!in_array($recette, $doublon)){
                array_push($doublon, $recette);
                $contenu->setProgramme($programme);
                $contenu->setRecette($recette);
                $programme->addRecette($contenu);
                $manager->persist($contenu);
                $i++;
            }            
        }

        $manager->persist($programme);
        $manager->flush();
        

        return $this->redirectToRoute('mon_programme');
    }

     /**
     * @Route("/inventaire", name = "mon_inventaire")
     *
     * Envoie l'inventaire de l'utilisateur à la vue
     * Si l'inventaire est vide, génère un inventaire aléatoire contenant entre 4 et 15 ingrédients
     *
     * @param ObjectManager $manager
     * @param InfoUserRepository $repoIU
     * @param IngredientRepository $repoIngred
     * @return void
     */
    public function mon_inventaire( ObjectManager $manager, InfoUserRepository $repoIU, IngredientRepository $repoIngred)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $InfoUser = $repoIU->find($this->getUser()->getId());

        if($InfoUser->getInventaire()->isEmpty()){
            for($i = 0; $i < rand(4, 15); $i++){
                $InfoUser->addInventaire($repoIngred->find(rand(0, 2180)));
                $manager->persist($InfoUser);
                $manager->flush();
            }
        }

        return $this->render('healtheat/inventaire.html.twig', [
            'inventaire' => $InfoUser->getInventaire(),
        ]);
    }

    /**
     * @Route("/suivi", name = "suivi_perso")
     *
     * Envoie les informations de poids, de temps d'activité ainsi que d'imc à la vue
     *
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function suivi_perso(InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $InfoUser = $repoIU->find($this->getUser()->getId());

        $imc_max = 0;
        $imc_bas = 18.5;
        $imc_haut = 25;

        $taille = $InfoUser->getTaille() / 100;

        $dataPoids = $InfoUser->getPoids();
        $dataTemps = $InfoUser->getTempsActivitePhysique();

        foreach ($dataPoids as $poids) {
            if(($poids->getPoids()/($taille*$taille)) > $imc_max){
                $imc_max = ($poids->getPoids()/($taille*$taille));
            }
        }

        return $this->render('healtheat/suivi.html.twig', [
        'infouser' => $InfoUser,
        'datapoids' => $dataPoids,
        'datatemps' => $dataTemps,
        'tailleuser' => $taille,
        'imcbas' => $imc_bas,
        'imchaut' => $imc_haut,
        'imcmax' => $imc_max,
        ]);
    }

    /**
     * @Route("/InfoCrea", name = "qui_sommes_nous")
     *
     * Affiche la page équipe
     *
     * @return void
     */
    public function qui_sommes_nous()
    {
        return $this->render('healtheat/qui_sommes_nous.html.twig', []);
    }


    /**
     * @Route("/suppr", name= "supprimer")
     *
     * Supprime le programme actuel
     * Fonction de test uniquement, n'est plus utilisé
     *
     * @param ObjectManager $manager
     * @param InfoUserRepository $repoIU
     * @return void
     */
    public function supprimer(ObjectManager $manager, InfoUserRepository $repoIU)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $InfoUser = $repoIU->find($this->getUser()->getId());

        $programme = $InfoUser->getProgrammes()->last();

        if($programme != false){
            $InfoUser->removeProgramme($programme);
            $manager->persist($InfoUser);
            $manager->flush();
        }

        return $this->redirectToRoute('mon_programme');
    }

    /**
     * @Route("/recette/{id}", name="recette")
     *
     * Affiche la page de la recette ayant l'identifiant {id} dans la base de donnée
     *
     * @param Recette $recette
     * @return void
     */
    public function recette(Recette $recette)
    {
        return $this->render('healtheat/recette.html.twig', [
            'recette' => $recette,
        ]);   
    }

    /**
     * @Route("/changement/{id}", name="changement")
     *
     * Change le contenu avec l'identifiant {id} dans le programme actuel
     * Le retour est au format Json
     * Fonction appelé par le bouton "changer" sur les recettes de la page programme
     *
     * @param ProgContenu $contenu
     * @param ObjectManager $manager
     * @param RecetteRepository $repoRecette
     * @return Response
     */
    public function changementRecette(ProgContenu $contenu, ObjectManager $manager, RecetteRepository $repoRecette) :
    Response {
        
        $oldRecette = $contenu->getRecette();

        $contenu->setRecette($repoRecette->find(rand(1,111)));

        $manager->persist($contenu);
        $manager->flush();

        return $this->json([
            'message' => 'Recette changé',
            'AncienneRecette' => $oldRecette->getNom(),
            'NouvelleRecette' => $contenu->getRecette()->getNom(),
            'TempsPrep' => $contenu->getRecette()->getTempsPrep(),
            'Difficulte' => $contenu->getRecette()->getDifficulte(),
            'Id' => $contenu->getRecette()->getId(),
            'Image' => $contenu->getRecette()->getImage(),
        ], 200);
    }

    /**
     * @Route("/supprimerIngredient/{id}", name="supprimer_ingred")
     *
     * Supprime l'ingredient avec l'identifiant {id} de l'inventaire
     * Le retour est au format Json
     * Fonction appelé par le bouton de suppression des ingredients sur la page inventaire
     *
     * @param [type] $id
     * @param ObjectManager $manager
     * @param InfoUserRepository $repoIU
     * @param IngredientRepository $repoIngred
     * @return Response
     */
    public function supprimerIngred($id ,ObjectManager $manager, InfoUserRepository $repoIU, IngredientRepository $repoIngred) :
    Response {

        $InfoUser = $repoIU->find($this->getUser()->getId());
        $ingredient = $repoIngred->find($id);
        $InfoUser->removeInventaire($ingredient);

        $manager->persist($InfoUser);
        $manager->flush();

        return $this->json([
            'message' => 'Ingredient supprimé',
            'ingredient' => $ingredient->getIngredient(),
        ]);
    }


    /**
     * @Route("/ajouterIngredient", name="ajouter_ingred")
     *
     * Ajoute un ingredient aléatoire dans l'inventaire
     * Le retour est au format Json
     * Fonction appelé par le bouton "ajouter produit" de la page inventaire
     *
     * @param ObjectManager $manager
     * @param IngredientRepository $repoIngred
     * @param InfoUserRepository $repoIU
     * @return Response
     */
    public function addIngred(ObjectManager $manager, IngredientRepository $repoIngred, InfoUserRepository $repoIU) :
    Response {
        
        $ingredient = $repoIngred->find(rand(1, 2180));

        $InfoUser = $repoIU->find($this->getUser()->getId());

        $InfoUser->addInventaire($ingredient);

        $manager->persist($InfoUser);
        $manager->flush();

        return $this->json([
            'message' => 'Ingredient ajouté',
            'ingredient' => $ingredient->getIngredient(),
            'id' => $ingredient->getId(),
        ]);
    }


    /**
     * @Route("/alerte", name="alerte")
     *
     * Enregistre un poids et un temps d'activité dans la base de donnée
     * Le retour est au format Json
     * Fonction appelé par l'alerte de la page index
     *
     * @param Request $requete
     * @param ObjectManager $manager
     * @param InfoUserRepository $repoIU
     * @return Response
     */
    public function savePoidsTemps(Request $requete, ObjectManager $manager, InfoUserRepository $repoIU) :
    Response {

        $date = new DateTime();

        $InfoUser = $repoIU->find($this->getUser()->getId());

        $poids = $requete->get('poids');
        $temps = $requete->get('temps'); 

        $InfoUser->setLPoids($poids);
        $InfoUser->setLTemps($temps);

        if($InfoUser->getLTemps() != NULL){
            $newtemps = new TempsEffortPhy();
            $newtemps->setInfoUser($InfoUser);
            $newtemps->setTemps($InfoUser->getLTemps());
            $newtemps->setDate($date);
            $manager->persist($newtemps);
            $manager->flush();
        }

        if($InfoUser->getLPoids() != NULL)
            {
                $newpoids = new Poids();
                $newpoids->setInfoUser($InfoUser);
                $newpoids->setPoids($InfoUser->getLPoids());
                $newpoids->setDate($date);
                $manager->persist($newpoids);
                $manager->flush();

                if($InfoUser->getTaille() != NULL){
                    $poids = $InfoUser->getLPoids();
                    $taille = $InfoUser->getTaille();
                    $taille = $taille / 100;
                    $IMC = $poids / ($taille * $taille);
                    $IMC = round($IMC,2);

                    $InfoUser->setImc($IMC);
                } else {
                    $InfoUser->setImc(NULL);
                }
            }

        $manager->persist($InfoUser);
        $manager->flush();

        return $this->json([
            'message' => 'Tout s\'est bien passé !',
            'newPoids' => $poids,
            'newTemps' => $temps,
        ]);
    }
} 

