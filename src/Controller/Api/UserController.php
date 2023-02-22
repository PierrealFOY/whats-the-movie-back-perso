<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * method that returns the list of users
     * @Route("/api/users", name="app_api_user_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'users']);
    }

    /**
     * method that returns one user
     * @Route("/api/users/{id}", name="app_api_user_show", methods={"GET"})
     * 
     * @param MovieRepository $movieRepository
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'users']);
    }

    /**
     * method that records a user 
     *@Route("/api/users", name="app_api_user_add", methods={"POST"})

     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $json = $request->getContent();

        $user = $serializer->deserialize($json, User::class, 'json');

        $errors = $validator->validate($user);

        if (count($errors)) {
            $errorsArray = [];

            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json($errorsArray,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->setRoles(["ROLE_USER"]);

        // I get my request in a array
        $content = $request->toArray();

        $password = $content['password'];

        $hashedPassword = $passwordHasher->hashPassword($user, $password);

        $user->setPassword($hashedPassword);

        $userRepository->add($user, true);

        return $this->json($user, Response::HTTP_CREATED, [
            'location' => $this->generateUrl("app_api_user_show", ["id" => $user->getId()])
        ], 
        ['groups' => 'users']);
    }

    /**
     * method to edit user profil
     *@Route("/api/users/{id}", name="app_api_user_edit", methods={"PUT"})

     * @param User $user
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @param UserPasswordHasherInterface $passwordHasher
     * @return JsonResponse
     */
    public function edit(User $user, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $json = $request->getContent();

        $editUser = $serializer->deserialize($json, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $errors = $validator->validate($user);

        if(count($errors) > 0){
            // Je créer un tableau avec mes erreurs
            $errorsArray = [];
            foreach($errors as $error){
                // A l'index qui correspond au champs mal remplis, j'y injecte le/les messages d'erreurs
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json($errorsArray,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // I get my request in a array
        $content = $request->toArray();

        $password = $content['password'];

        $hashedPassword = $passwordHasher->hashPassword($user, $password);

        $user->setPassword($hashedPassword);        
        
        $em->persist($editUser);

        $em->flush();
    
        return $this->json(null,
        Response::HTTP_NO_CONTENT, [
            "Location" => $this->generateUrl("app_api_user_show", ["id" => $user->getId()])
        ], 
        ["groups" => "users"]);
    }

    /**
     * method to delete account
     * @Route("/api/users/{id}", name="app_api_user_delete", methods={"DELETE"})
     *
     * @param User $user
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function delete(User $user, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($user);

        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
} 
