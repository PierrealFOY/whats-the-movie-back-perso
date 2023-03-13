<?php

namespace App\Controller\Back;

use App\Controller\Back\MainController;
use App\Entity\User;
use App\Form\UserPasswordType;
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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends MainController
{
    /**
     * @Route("/back-office/utilisateur", name="app_back_user_list")
     */
    public function list(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $userRepository->findBy([],['roles' => 'asc']);

        $users = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('back/user/list.html.twig', [
            'users' => $users,
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
            // On vient hasher les password pour qu'ils soient illisibles
            $hashedPassword = $userPasswordHasherInterface->hashPassword(
                $user,
                // ça correspond à la saisie en clair du MDP
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
    public function edit(Request $request, int $id, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $em): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user, ["edit" => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();


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

     /**
     * @Route("/back-office/utilisateur/modifier/password/{id}", name="app_back_user_editPassword", methods={"GET","POST"})
     * To edit a user by his ID
     */
    public function editPassword(Request $request, int $id, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $em, UserInterface $userInterface): Response
    {
        
        $user = $userRepository->find($id);
        $this->denyAccessUnlessGranted('PASSWORD_EDIT', $user);
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $form->get('oldPassword')->getData();

            if (!$userPasswordHasherInterface->isPasswordValid($user, $oldPassword)) {
                $this->addFlash(
                    "danger",
                    "L'ancien mot de passe ne correspond pas"
                );
                return $this->redirectToRoute('app_back_user_editPassword', ["id" => $user->getId()]);
            }

            $hashedPassword = $userPasswordHasherInterface->hashPassword(
                $user,
                $form->get('password')->getData()
            );

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();


            $this->addFlash(
                "warning",
                "Le mot de passe a bien été modifié"
            );

            return $this->redirectToRoute('app_back_user_list', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('back/user/edit_password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}