<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="app_categories_index", methods={"GET"})
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/new", name="app_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category, [
            'attr' => [
                'class' => ''
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->add($category, true);

            return $this->redirectToRoute('app_categories_index', [
                'role_user' => $role,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/stats", name="app_categories_stats")
     */
    public function statistiques(CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $categories = $categoriesRepository->findAll();

        $categoriesJson = [];
        $categoriesJson['name'] = [];
        $categoriesJson['color'] = [];
        $categoriesJson['count'] = [];
        $categoriesJson['price'] = [];

        foreach ($categories as $categorie) {
            $categoriesJson['name'][] = $categorie->getName();
            $categoriesJson['color'][] = $categorie->getColor();
            $categoriesJson['count'][] = count($categorie->getProduits());
            $priceTotal = 0;
            foreach ($categorie->getProduits() as $produit) {
                $priceTotal += $produit->getPrice();
            }
            $categoriesJson['price'][] = $priceTotal;
        }

        return $this->render('categories/stats.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'categoriesJson' => json_encode($categoriesJson),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="app_categories_show", methods={"GET"})
     */
    public function show(Categories $category): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->add($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="app_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoriesRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_categories_index', [
            'role_user' => $role,
        ], Response::HTTP_SEE_OTHER);
    }
}
