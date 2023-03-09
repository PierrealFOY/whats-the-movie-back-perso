<?php

namespace App\Controller\Back;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/back-office/pays", name="app_back_country_index", methods={"GET"})
     */
    public function index(Request $request, CountryRepository $countryRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $countryRepository->findBy([],['name' => 'asc']);

        $countries = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('back/country/index.html.twig', [
            'countries' => $countries,
        ]);
    }

    /**
     * @Route("/back-office/pays/ajouter", name="app_back_country_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CountryRepository $countryRepository): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $countryRepository->add($country, true);

            $this->addFlash(
                "success",
                "Le pays a bien été ajouté"
            );

            return $this->redirectToRoute('app_back_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/country/new.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/pays/{id}", name="app_back_country_show", methods={"GET"})
     */
    public function show(CountryRepository $countryRepository, int $id): Response
    {
        $country = $countryRepository->find($id);

        return $this->render('back/country/show.html.twig', [
            'country' => $country,
        ]);
    }

    /**
     * @Route("/back-office/pays/modifier/{id}", name="app_back_country_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CountryRepository $countryRepository, int $id): Response
    {
        $country = $countryRepository->find($id);
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $countryRepository->add($country, true);

            $this->addFlash(
                "warning",
                "Le pays a bien été modifié"
            );

            return $this->redirectToRoute('app_back_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/country/edit.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/back-office/pays/supprimer/{id}", name="app_back_country_delete", methods={"POST"})
     */
    public function delete(Request $request, CountryRepository $countryRepository, int $id): Response
    {
        $country = $countryRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->request->get('_token'))) {
            $countryRepository->remove($country, true);
        }

        $this->addFlash(
            "danger",
            "Le pays a bien été supprimé"
        );

        return $this->redirectToRoute('app_back_country_index', [], Response::HTTP_SEE_OTHER);
    }
}
