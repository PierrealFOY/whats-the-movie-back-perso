<?php

namespace App\Controller\Back;

use App\Entity\ProductionStudio;
use App\Form\ProductionStudioType;
use App\Repository\ProductionStudioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductionStudioController extends AbstractController
{
    /**
     * @Route("/back-office/studio-production", name="app_back_productionStudio_index", methods={"GET"})
     */
    public function index(Request $request,ProductionStudioRepository $ProductionStudioRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $ProductionStudioRepository->findBy([],['name' => 'asc']);

        $productionStudios = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('back/production_studio/index.html.twig', [
            'productionStudios' => $productionStudios,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/ajouter", name="app_back_productionStudio_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductionStudioRepository $productioStudioRepository): Response
    {
        $productionStudio = new ProductionStudio();
        $form = $this->createForm(ProductionStudioType::class, $productionStudio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productioStudioRepository->add($productionStudio, true);

            $this->addFlash(
                "success",
                "Le studio de production a bien été ajoutée"
            );

            return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/production_studio/new.html.twig', [
            'productionStudio' => $productionStudio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/{id}", name="app_back_productionStudio_show", methods={"GET"})
     */
    public function show(ProductionStudioRepository $productionStudioRepository, int $id): Response
    {
        $productionStudio = $productionStudioRepository->find($id);

        return $this->render('back/production_studio/show.html.twig', [
            'productionStudio' => $productionStudio,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/modifier/{id}", name="app_back_productionStudio_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,ProductionStudioRepository $productionStudionRepository, int $id): Response
    {
        $productionStudio = $productionStudionRepository->find($id);
        $form = $this->createForm(ProductionStudioType::class, $productionStudio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productionStudionRepository->add($productionStudio, true);

            $this->addFlash(
                "warning",
                "Le studio de production a bien été modifié"
            );

            return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/production_studio/edit.html.twig', [
            'productionStudio' => $productionStudio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/studio-production/supprimer/{id}", name="app_back_productionStudio_delete", methods={"POST"})
     */
    public function delete(Request $request, ProductionStudioRepository $productionStudioRepository, int $id): Response
    {
        $productionStudio = $productionStudioRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$productionStudio->getId(), $request->request->get('_token'))) {
            $productionStudioRepository->remove($productionStudio, true);
        }

        $this->addFlash(
            "danger",
            "Le studio de production a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_productionStudio_index', [], Response::HTTP_SEE_OTHER);
    }
}
