<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;

use App\Form\LoginType;



class LoginController extends AbstractController

{
     /**
     * @Route("/back-office/login", name="app_back_login_index")
     */
    
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('back/login/index.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            
        ]);
        
     }

    /**
     * @Route("/back-office/logout", name="app_back_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

}
