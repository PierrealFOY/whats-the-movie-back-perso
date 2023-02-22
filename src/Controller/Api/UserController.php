<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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


}
