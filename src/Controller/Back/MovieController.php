<?php

namespace App\Controller\Back;

use App\Data\SearchData;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Form\SearchFormType;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieController extends AbstractController
{
    /**
     * @Route("/back-office/film", name="app_back_movie_home", methods={"GET"})
     */
    public function home(MovieRepository $movieRepository, Request $request): Response
    {

        $data = new SearchData;
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);
        $movies = $movieRepository->findSearch($data);

        return $this->render('back/movie/index.html.twig', [
            'movies' => $movies,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/back-office/film/ajouter", name="app_back_movie_add", methods={"GET", "POST"})
     */
    public function add(Request $request, MovieRepository $movieRepository, UserInterface $user, UserRepository $userRepository ): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $userConecting = $user->getUserIdentifier();

            $user = $userRepository->findOneBy(["email" => $userConecting]);

            $movie->setUser($user);

            $movieRepository->add($movie, true);

            $this->addFlash(
                "success",
                "Le film est bien ajouté");

            return $this->redirectToRoute('app_back_movie_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/film/{id}", name="app_back_movie_show", methods={"GET"})
     */
    public function show(MovieRepository $movieRepository, int $id): Response
    {
        $movie= $movieRepository->find($id);

        return $this->render('back/movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/back-office/film/modifier/{id}", name="app_back_movie_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, MovieRepository $movieRepository , int $id): Response
    {
        $movie= $movieRepository->find($id);
        
        $form = $this->createForm(MovieType::class, $movie);
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
     
            
            $movieRepository->add($movie, true);

            $this->addFlash(
                "warning",
                "Le film est bien modifié");


            return $this->redirectToRoute('app_back_movie_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/film/supprimer/{id}", name="app_back_movie_delete", methods={"POST"})
     */
    public function delete(Request $request, MovieRepository $movieRepository , int $id): Response
    {
        $movie= $movieRepository->find($id);
        
         if ($this->isCsrfTokenValid( 'delete'.$movie->getId(), $request->get('_token'))){
            $movieRepository->remove($movie, true);

            $this->addFlash(
                "danger",
                "Le film est bien supprimé");

        }
        
        return $this->redirectToRoute('app_back_movie_home', [], Response::HTTP_SEE_OTHER);
    }
 
    //     /** 
    //  * @Route("/back-office/film", name="app_back_movie_home")
    //  */
    // public function search (Request $request, MovieRepository $movieRepository)
    // {

    //     $movies = $movieRepository->searchByTitle($request->get("search"));

    //     return $this->render('back/movie/index.html.twig', [
    //         'movies' => $movies,
    //     ]);
    // }

}
