<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/back-office/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_back_user_list")
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('back/user/list.html.twig', [
            'users' => $userRepository->findAll(),
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
     * @Route("/ajouter", name="app_back_user_add", methods={"GET","POST"})
     * Je viens ajouter un utilisateur
     */
    public function add(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
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

     /**
     * @Route("/modifier/{id}", name="app_back_user_edit", methods={"GET","POST"})
     * On vient ici modifier un user par son ID
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(UserType::class, $user,["edit" => true]);
        $form>handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('back/user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/supprimer/{id}", name="app_back_user_delete", methods={"POST"})
     * On vient supprimer un utilisateur par son ID
     */
    public function delete(Request $request, User $user, UserRepository $userRepository)
    {
        // On récupère la valeur du Token et on vient vérifier sa validité
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
    }

}
