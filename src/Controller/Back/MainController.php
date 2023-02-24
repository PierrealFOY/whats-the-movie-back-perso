<?php

namespace App\Controller;


use App\Controller\UserController;
use App\Controller\MovieController;
use App\Entity\User;
use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_back_home")
     */
    public function home(): Response
    {
        return $this->render('back/main/home.html.twig', [
            'main' => 'MainController',
        ]);
    }
}
