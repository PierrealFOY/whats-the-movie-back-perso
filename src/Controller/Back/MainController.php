<?php

namespace App\Controller\Back;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_back_home")
     * This route is used to redirect to the home page
     * This is the root of the back office
     */
    public function home(): Response
    {
        return $this->render('back/main/home.html.twig', [
            'main' => 'MainController',
        ]);
    }
}
