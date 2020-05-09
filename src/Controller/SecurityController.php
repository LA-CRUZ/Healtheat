<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\InfoUser;

use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function inscription(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $InfoUser = new InfoUser();

        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->persist($InfoUser);
            $manager->flush();


            return $this->redirectToRoute('security_connexion');
        }
       
        $estCo = false;

        if($this->getUser() == NULL && $estCo == false){
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView()
        ]);
        $estCo = true;
        }
        else{
            //return $this->render('healtheat/index.html.twig', []);
            return $this->redirectToRoute('healtheat');
        }


    }

    /**
     * @Route("/connexion", name="security_connexion")
     */
    public function connexion(){
        return $this->render('security/connexion.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}
}
