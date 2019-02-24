<?php

namespace App\Controller;

use App\Entity\InfoUser;
use App\Form\InfoPersoType;

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
        $id = $this->getUser()->getId();

        $InfoUser = $manager->getRepository(InfoUser::class)->find($id);

        $form = $this->createForm(InfoPersoType::class, $InfoUser);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($InfoUser->getPoids() != NULL && $InfoUser->getTaille() != NULL)
            {
                $poids = $InfoUser->getPoids();
                $taille = $InfoUser->getTaille();
                $taille = $taille / 100;
                $IMC = $poids / ($taille * $taille);

                $InfoUser->setImc($IMC);
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
        $repository = $this->getDoctrine()->getRepository(InfoUser::class);

        $id = $this->getUser()->getId();

        $info = $repository->find($id);

        return $this->render('healtheat/infoperso.html.twig', [
            'info_user' => $info,
            'user' => $this->getUser()
        ]);
    }
}
