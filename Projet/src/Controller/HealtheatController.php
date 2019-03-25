<?php

namespace App\Controller;

use DateTime;
use App\Entity\Poids;

use App\Entity\InfoUser;
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
    public function index()
    {
        return $this->render('healtheat/index.html.twig', [
            'controller_name' => 'HealtheatController',
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

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notice',
                'Vos changement ont été sauvegardé !'
            );
            $date = new DateTime();
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
            'controller_name' => 'HealtheatController', 
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
    public function mon_programme()
    {
        if($this->getUser() == NULL){
            return $this->render('security/connexion.html.twig', [
                'controller_name' => 'Healtheat_Controller',
            ]);
        }

        return $this->render('healtheat/programme.html.twig', [
            'controller_name' => 'HealtheatController',
        ]);
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
    public function page_test()
    {
        $repository = $this->getDoctrine()->getRepository(InfoUser::class);

        $date = new DateTime();

        $id = $this->getUser()->getId();

        $info = $repository->find($id);

        if ($info->getPoids()->last() != NULL) 
            $datePoids = $info->getPoids()->last()->getDate()->diff($date);
        else   
            $datePoids = NULL;

        if ($info->getTempsActivitePhysique()->last() != NULL) 
            $dateTemps = $info->getTempsActivitePhysique()->last()->getDate()->diff($date);
        else   
            $dateTemps = NULL;


        return $this->render('healtheat/page_test.html.twig', [
            'datePoids' => $datePoids,
            'dateTemps' => $dateTemps,
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
} 



