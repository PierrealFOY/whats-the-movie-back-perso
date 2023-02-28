<?php

namespace App\Controller\Back;

use Symfony\Component\Form\FormTypeInterface;
use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
     * @Route("/back-office/genre", name="app_back_genre_index", methods={"GET"})
     */
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('back/genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back-office/genre/ajouter", name="app_back_genre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GenreRepository $genreRepository): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreRepository->add($genre, true);

            $this->addFlash(
                "success",
                "Le genre a bien été ajoutée"
            );

            return $this->redirectToRoute('app_back_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/genre/{id}", name="app_back_genre_show", methods={"GET"})
     */
    public function show(GenreRepository $genreRepository, int $id): Response
    {
        $genre = $genreRepository->find($id);

        return $this->render('back/genre/show.html.twig', [
            'genre' => $genre,
        ]);
    }

    /**
     * @Route("/back-office/genre/modifier/{id}", name="app_back_genre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, GenreRepository $genreRepository, int $id): Response
    {
        $genre = $genreRepository->find($id);
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreRepository->add($genre, true);

            $this->addFlash(
                "warning",
                "Le genre a bien été modifié"
            );

            return $this->redirectToRoute('app_back_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/genre/supprimer/{id}", name="app_back_genre_delete", methods={"POST"})
     */
    public function delete(Request $request, GenreRepository $genreRepository, int $id): Response
    {
        $genre = $genreRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $genreRepository->remove($genre, true);
        }

        $this->addFlash(
            "danger",
            "Le genre a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
