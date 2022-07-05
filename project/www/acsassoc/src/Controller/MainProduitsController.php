<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;
use App\Repository\CategoriesRepository;
use App\Entity\Produits;
use App\Entity\Categories;

/**
* @Route("/main/produits", name="app_main_produits_")
*/
class MainProduitsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('main_produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
            'role_user' => $role,
        ]);
    }
    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorieMain(CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $categories = $categoriesRepository->findAll();
        $categorie = $categoriesRepository->findAll()[0];

        return $this->render('main_produits/categorie.html.twig', [
            'produits' => $categorie->getProduits(),
            'categories' => $categories,
            'categorie_id' => $categorie->getId(),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie_id", methods={"GET"})
     */
    public function categorie(Categories $categorie, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $categories = $categoriesRepository->findAll();

        return $this->render('main_produits/categorie.html.twig', [
            'produits' => $categorie->getProduits(),
            'categories' => $categories,
            'categorie_id' => $categorie->getId(),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Produits $produit): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('main_produits/show.html.twig', [
            'produit' => $produit,
            'role_user' => $role,
        ]);
    }
}
