<?php

namespace App\Controller\Back;

use App\Entity\Director;
use App\Form\DirectorType;
use App\Repository\DirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectorController extends AbstractController
{
    /**
     * @Route("/back-office/realisateur", name="app_back_director_index", methods={"GET"})
     */
    public function index(DirectorRepository $directorRepository): Response
    {
        return $this->render('back/director/index.html.twig', [
            'directors' => $directorRepository->findBy([], ['lastname' => 'ASC']),
        ]);
    }

    /**
     * @Route("/back-office/realisateur/ajouter", name="app_back_director_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DirectorRepository $directorRepository): Response
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directorRepository->add($director, true);

            $this->addFlash(
                "success",
                "Le réalisateur a bien été ajoutée"
            );

            return $this->redirectToRoute('app_back_director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/director/new.html.twig', [
            'director' => $director,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/realisateur/{id}", name="app_back_director_show", methods={"GET"})
     */
    public function show(DirectorRepository $directorRepository, int $id): Response
    {
        $director = $directorRepository->find($id);

        return $this->render('back/director/show.html.twig', [
            'director' => $director,
        ]);
    }

    /**
     * @Route("/back-office/realisateur/modifier/{id}", name="app_back_director_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DirectorRepository $directorRepository, int $id): Response
    {
        $director = $directorRepository->find($id);
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directorRepository->add($director, true);

            $this->addFlash(
                "warning",
                "Le réalisateur a bien été modifié"
            );

            return $this->redirectToRoute('app_back_director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/director/edit.html.twig', [
            'director' => $director,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/realisateur/supprimer/{id}", name="app_back_director_delete", methods={"POST"})
     */
    public function delete(Request $request, DirectorRepository $directorRepository, int $id): Response
    {
        $director = $directorRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$director->getId(), $request->request->get('_token'))) {
            $directorRepository->remove($director, true);
        }

        $this->addFlash(
            "danger",
            "Le réalisateur a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_director_index', [], Response::HTTP_SEE_OTHER);
    }
}
