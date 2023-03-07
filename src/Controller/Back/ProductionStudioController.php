<?php

namespace App\Controller\Back;

use App\Entity\ProductionStudio;
use App\Form\ProductionStudioType;
use App\Repository\ProductionStudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductionStudioController extends AbstractController
{
    /**
     * @Route("/back-office/studio-production", name="app_back_productionStudio_index", methods={"GET"})
     */
    public function index(ProductionStudioRepository $ProductionStudioRepository): Response
    {
        return $this->render('back/production_studio/index.html.twig', [
            'ProductionStudios' => $ProductionStudioRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    /**
     * @Route("/back-office/studio-production/ajouter", name="app_back_productionStudio_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductionStudioRepository $ProductioStudioRepository): Response
    {
        $ProductionStudio = new ProductionStudio();
        $form = $this->createForm(ProductionStudioType::class, $ProductionStudio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ProductioStudioRepository->add($ProductionStudio, true);

            $this->addFlash(
                "success",
                "Le studio de production a bien été ajoutée"
            );

            return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/production_studio/new.html.twig', [
            'ProductionStudio' => $ProductionStudio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/{id}", name="app_back_productionStudio_show", methods={"GET"})
     */
    public function show(ProductionStudioRepository $ProductionStudioRepository, int $id): Response
    {
        $ProductionStudio = $ProductionStudioRepository->find($id);

        return $this->render('back/production_studio/show.html.twig', [
            'ProductionStudio' => $ProductionStudio,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/modifier/{id}", name="app_back_productionStudio_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,ProductionStudioRepository $ProductionStudionRepository, int $id): Response
    {
        $ProductionStudio = $ProductionStudionRepository->find($id);
        $form = $this->createForm(ProductionStudioType::class, $ProductionStudio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ProductionStudionRepository->add($ProductionStudio, true);

            $this->addFlash(
                "warning",
                "Le studio de production a bien été modifié"
            );

            return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/production_studio/edit.html.twig', [
            'ProductionStudio' => $ProductionStudio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/supprimer/{id}", name="app_back_productionStudio_delete", methods={"POST"})
     */
    public function delete(Request $request, ProductionStudioRepository $ProductionStudioRepository, int $id): Response
    {
        $ProductionStudio = $ProductionStudioRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$ProductionStudio->getId(), $request->request->get('_token'))) {
            $ProductionStudioRepository->remove($ProductionStudio, true);
        }

        $this->addFlash(
            "danger",
            "Le studio de production a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
    }
}
