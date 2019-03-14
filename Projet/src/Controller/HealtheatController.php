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
        if($this->getUser()->getId() == NULL){
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
                'Vos changement on été sauvegardé !'
            );
            $date = new DateTime();
            if($InfoUser->getLPoids() != NULL)
            {
                    $dernierPoids = $InfoUser->getPoids()->last();
                    if($dernierPoids != FALSE){
                        $dernierPoids = $dernierPoids->getPoids();
                    }
                    if($dernierPoids == FALSE or $InfoUser->getPoids()->last()->getDate()->diff($date)->format('%d') > 0){
                        $newpoids = new Poids();
                        $newpoids->setInfoUser($InfoUser);
                        $newpoids->setPoids($InfoUser->getLPoids());
                        $newpoids->setDate($date);
                        $manager->persist($newpoids);
                        $manager->flush();
                    }

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
            if($InfoUser->getLTemps() != NULL and $InfoUser->getTempsActivitePhysique()->last()->getDate()->diff($date)->format('%d') > 0){
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
        if($this->getUser()->getId() == NULL){
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
        return $this->render('healtheat/programme.html.twig', [
            'controller_name' => 'HealtheatController',
        ]);
    }

     /**
     * @Route("/inventaire", name = "mon_inventaire")
     */
    public function mon_inventaire()
    {
        return $this->render('healtheat/inventaire.html.twig', [
            'controller_name' => 'HealtheatController',
        ]);
    }

    /**
    * @Route("/suivi", name = "suivi_perso")
    */

    public function suivi_perso()
    {
        if($this->getUser()->getId() == NULL){
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

        return $this->render('healtheat/suivi.html.twig', [
        'infouser' => $info,
        'datapoids' => $dataPoids,
        'datatemps' => $dataTemps,
        'tailleuser' => $taille,
        ]);
    }
}

