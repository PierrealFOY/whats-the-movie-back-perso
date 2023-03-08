<?php

namespace App\Controller\Back;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/back-office/acteur", name="app_back_actor_index", methods={"GET"})
     */
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('back/actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back-office/acteur/ajouter", name="app_back_actor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ActorRepository $actorRepository): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actorRepository->add($actor, true);

            $this->addFlash(
                "success",
                "L'acteur a bien été ajouté"
            );

            return $this->redirectToRoute('app_back_actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/acteur/{id}", name="app_back_actor_show", methods={"GET"})
     */
    public function show(ActorRepository $actorRepository, int $id): Response
    {
        $actor = $actorRepository->find($id);

        return $this->render('back/actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }

    /**
     * @Route("/back-office/acteur/modifier/{id}", name="app_back_actor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ActorRepository $actorRepository, int $id): Response
    {
        $actor = $actorRepository->find($id);
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actorRepository->add($actor, true);

            $this->addFlash(
                "warning",
                "L'acteur a bien été modifié"
            );

            return $this->redirectToRoute('app_back_actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/acteur/supprimer/{id}", name="app_back_actor_delete", methods={"POST"})
     */
    public function delete(Request $request, ActorRepository $actorRepository, int $id): Response
    {
        $actor = $actorRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->request->get('_token'))) {
            $actorRepository->remove($actor, true);
        }

        $this->addFlash(
            "danger",
            "L'acteur a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_actor_index', [], Response::HTTP_SEE_OTHER);
    }
}
