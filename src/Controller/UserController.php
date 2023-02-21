<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back-office/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_back_user_list")
     */
    public function list(): Response
    {
        return $this->render('user/list.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_show", methods={"GET"})
     * Je viens récupérer l'utilisateur par son ID
     */
    public function show(User $user): Response 
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/ajouter", name="app_back_user_add", methods={"GET"})
     * Je viens ajouter un utilisateur
     */
    public function add(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createCreateForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On vient hasher les password pour qu'ils soient illisibles
            $hashedPassword = $userPasswordHasherInterface->hashPassword(
                $user,
                // ça correspond à la saisie en clair du MDP
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $userRepository->add($user, true);

            return $this->redirectToRoute('back/user/new.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
    }

}
