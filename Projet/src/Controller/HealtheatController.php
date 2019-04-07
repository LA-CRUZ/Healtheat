<?php

namespace App\Controller;

use DateTime;
use App\Entity\Poids;

use App\Entity\Recette;
use App\Entity\InfoUser;
use App\Entity\Programmes;
use App\Form\InfoPersoType;
use App\Entity\TempsEffortPhy;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HealtheatController extends AbstractController
{
    /**
     * @Route("/", name="healtheat")
     */
    public function index(Request $requete, ObjectManager $manager)
    {
        // $id = $this->getUser()->getId();

        // $InfoUser = $manager->getRepository(InfoUser::class)->find($id);

        // $date = new DateTime();

        // if ($InfoUser->getPoids()->last() != NULL) 
        //     $datePoids = $InfoUser->getPoids()->last()->getDate()->diff($date);
        // else   
        //     $datePoids = NULL;

        // if ($InfoUser->getTempsActivitePhysique()->last() != NULL) 
        //     $dateTemps = $InfoUser->getTempsActivitePhysique()->last()->getDate()->diff($date);
        // else   
        //     $dateTemps = NULL;

        // if($requete->isXMLHttpRequest()){
        //     $poids = $request->get('poids');
        //     $sport = $request->get('sport');

        //     var_dump($poids);
        // }

        return $this->render('healtheat/index.html.twig', [
        //    'datePoids' => $datePoids,
        //    'dateTemps' => $dateTemps
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

        $iduser = $this->getUser()->getId();

        $user = $repositoryUser->find($iduser);

        $programme = new Programmes();

        $programme->setDateDebut($date);

        $i = 0;

        $programme->setUtilisateur($user);

        while($i < 14){
            $recette = new Recette();

            $id = rand(1, 111);

            $recette = $repositoryRecette->find($id);

            if(!$programme->getRecette()->contains($recette)){
                $programme->addRecette($recette);
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

        $taille = $info->getTaille();

        $taille = $taille / 100;

        $dataPoids = $info->getPoids();
        $dataTemps = $info->getTempsActivitePhysique();

        $imc_bas = 18.5;
        $imc_haut = 25;

        return $this->render('healtheat/suivi.html.twig', [
        'infouser' => $info,
        'datapoids' => $dataPoids,
        'datatemps' => $dataTemps,
        'tailleuser' => $taille,
        'imcbas' => $imc_bas,
        'imchaut' => $imc_haut,
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
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }
            

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
} 



