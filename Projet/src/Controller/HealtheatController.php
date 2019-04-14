<?php

namespace App\Controller;

use DateTime;
use App\Entity\Poids;

use App\Entity\Recette;
use App\Entity\InfoUser;
use App\Entity\Programmes;
use App\Entity\ProgContenu;
use App\Form\InfoPersoType;
use App\Entity\TempsEffortPhy;
use App\Repository\RecetteRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HealtheatController extends AbstractController
{
    /**
     * @Route("/", name="healtheat")
     */
    public function index(Request $requete, ObjectManager $manager)
    {
        if($this->getUser() != NULL){
            $id = $this->getUser()->getId();
            $InfoUser = $manager->getRepository(InfoUser::class)->find($id);
            $programme = $InfoUser->getProgrammes()->last();
        } else {
            $programme = NULL;
        }


        return $this->render('healtheat/index.html.twig', [
            'programme' => $programme,
        ]);
    }

    /**
     * @Route("/perso", name="espace_perso")
     */
    public function perso(Request $request, ObjectManager $manager)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }
        $id = $this->getUser()->getId();

        $InfoUser = $manager->getRepository(InfoUser::class)->find($id);

        $form = $this->createForm(InfoPersoType::class, $InfoUser);

        $form->handleRequest($request);

        $date = new DateTime();

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notice',
                'Vos changement ont été sauvegardé !'
            );
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
     */
    public function info_perso()
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }
        $repository = $this->getDoctrine()->getRepository(InfoUser::class);

        $id = $this->getUser()->getId();

        $info = $repository->find($id);

        return $this->render('healtheat/infoperso.html.twig', [
            'info_user' => $info,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/programme", name = "mon_programme")
     */
    public function mon_programme(ObjectManager $manager)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $repository = $manager->getRepository(Programmes::class);
        $repositoryUser = $manager->getRepository(InfoUser::class);

        $user = $this->getUser();
        $InfoUser = $repositoryUser->find($user->getId());

        $programme = $InfoUser->getProgrammes()->last();

        return $this->render('healtheat/programme.html.twig', [
            'programmes' => $programme,
        ]);
    }


    /**
     * @Route("/generer", name="generer_programme")
     */
    public function generer_programme(ObjectManager $manager)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $date = new DateTime();

        $repositoryRecette = $manager->getRepository(Recette::class);
        $repositoryUser = $manager->getRepository(InfoUser::class);
        $repositoryContenu = $manager->getRepository(ProgContenu::class);

        $iduser = $this->getUser()->getId();

        $user = $repositoryUser->find($iduser);

        $programme = new Programmes();

        $programme->setDateDebut($date);

        $i = 0;

        $programme->setUtilisateur($user);

        $doublon = array();

        while($i < 14){
            $contenu = new ProgContenu();
            $recette = new Recette();

            $id = rand(1, 111);

            $recette = $repositoryRecette->find($id);

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
     */
    public function mon_inventaire()
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        return $this->render('healtheat/inventaire.html.twig', [
            'controller_name' => 'HealtheatController',
        ]);
    }

    /**
    * @Route("/suivi", name = "suivi_perso")
    */

    public function suivi_perso()
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }
        $repository = $this->getDoctrine()->getRepository(InfoUser::class);

        $id = $this->getUser()->getId();

        $info = $repository->find($id);

        $imc_max = 0;

        $taille = $info->getTaille();

        $taille = $taille / 100;

        $dataPoids = $info->getPoids();
        $dataTemps = $info->getTempsActivitePhysique();

        foreach ($dataPoids as $poids) {
            if(($poids->getPoids()/($taille*$taille)) > $imc_max){
                $imc_max = ($poids->getPoids()/($taille*$taille));
            }
        }

        $imc_bas = 18.5;
        $imc_haut = 25;

        return $this->render('healtheat/suivi.html.twig', [
        'infouser' => $info,
        'datapoids' => $dataPoids,
        'datatemps' => $dataTemps,
        'tailleuser' => $taille,
        'imcbas' => $imc_bas,
        'imchaut' => $imc_haut,
        'imcmax' => $imc_max,
        ]);
    }

    /**
     * @Route("/test", name = "page_test")
     */
    public function page_test(ObjectManager $manager)
    {
        $repository = $manager->getRepository(Programmes::class);
        $repositoryUser = $manager->getRepository(InfoUser::class);

        $user = $this->getUser();
        $InfoUser = $repositoryUser->find($user->getId());

        $programme = $InfoUser->getProgrammes()->last();
 

        return $this->render('healtheat/page_test.html.twig', [
            'programmes' => $programme,
        ]);
    }

    /**
     * @Route("/InfoCrea", name = "qui_sommes_nous")
     */
    public function qui_sommes_nous()
    {
       
            

        return $this->render('healtheat/qui_sommes_nous.html.twig', [
            'controller_name' => 'HealtheatController',
        ]);
    }


    /**
     * @Route("/suppr", name= "supprimer")
     */
    public function supprimer(ObjectManager $manager)
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        $repositoryUser = $manager->getRepository(InfoUser::class);

        $iduser = $this->getUser()->getId();

        $user = $repositoryUser->find($iduser);

        $programme = $user->getProgrammes()->last();

        if($programme != false){
            $user->removeProgramme($programme);
            $manager->persist($user);
            $manager->flush();
        }

        return $this->redirectToRoute('mon_programme');

    }

    /**
     * @Route("/recette/{id}", name="recette")
     */
    public function recette(Recette $recette)
    {
        return $this->render('healtheat/recette.html.twig', [
            'recette' => $recette,
        ]);   
    }

    /**
     * @Route("/changement/{id}", name="changement")
     */
    public function changementRecette(ProgContenu $contenu, ObjectManager $manager, RecetteRepository $repoR) :
    Response {


        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        $random = rand(1,111);
        $newRecette = $repoR->find($random);

        $recette = $contenu->getRecette();

        $contenu->setRecette($newRecette);

        $manager->persist($contenu);
        $manager->flush();

        $data = $serializer->serialize($newRecette, 'json', [
            'circular_reference_handler' => function ($newRecette) {
                return $newRecette->getId();
            }
        ]);

        return $this->json([
            'message' => 'Recette changé',
            'AncienneRecette' => $recette->getNom(),
            'NouvelleRecette' => $newRecette->getNom(),
            'TempsPrep' => $newRecette->getTempsPrep(),
            'Difficulte' => $newRecette->getDifficulte(),
            'Id' => $newRecette->getId(),
            'Image' => $newRecette->getImage(),
        ], 200);
    }
} 



