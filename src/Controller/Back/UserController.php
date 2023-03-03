<?php

namespace App\Controller\Back;

use App\Controller\Back\MainController;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends MainController
{
    /**
     * @Route("/back-office/utilisateur", name="app_back_user_list")
     * List of all the users from the Repository
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('back/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back-office/utilisateur/ajouter", name="app_back_user_add", methods={"GET","POST"})
     * To add a user
     */
    public function add(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The password is hashed and stored in the database
            $hashedPassword = $userPasswordHasherInterface->hashPassword(
                $user,
                // this is the password you input in clear 
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $userRepository->add($user, true);

            $this->addFlash(
                "success",
                "Super! Le nouvel utilisateur a bien été ajouté !"
            );


            return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            ]);
    }

     /**
     * @Route("/back-office/utilisateur/modifier/{id}", name="app_back_user_edit", methods={"GET","POST"})
     * To edit a user by his ID
     */
    public function edit(Request $request, int $id, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user, ["edit" => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            $this->addFlash(
                "warning",
                "L'utilisateur a bien été modifié"
            );

            return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/utilisateur/{id}", name="app_back_user_show", methods={"GET"})
     * To get a user by his ID
     */
    public function show(UserRepository $userRepository, int $id): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $userRepository->find($id)
        ]);
    }

    /**
     * @Route("/back-office/utilisateur/supprimer/{id}", name="app_back_user_delete", methods={"POST"})
     * To delete a user by his ID
     */
    public function delete(Request $request, int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        // On récupère la valeur du Token et on vient vérifier sa validité
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        $this->addFlash(
            "danger",
            "L'utilisateur a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
    }

}