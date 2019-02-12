<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

}
