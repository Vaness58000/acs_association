<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchProduitsType;
use App\Entity\Produits;
use App\Entity\Categories;
use App\ClassMain\ConfigSite;

/**
* @Route("/main/produits", name="app_main_produits_")
*/
class MainProduitsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProduitsRepository $produitsRepository, Request $request): Response
    {
        $config = new ConfigSite();

        $user = $this->getUser();
        $role = $user->getRoles()[0];

        // on definit le nombre de d'elements par page
        $limit = $config->getNb_prod();

        $page = (int)$request->query->get("page", 1);

        $produit = $produitsRepository->getPaginatedProduits($page, $limit);
        $pages = ceil($produitsRepository->getTotalProduits()/$limit);

        //$produit = $produitsRepository->findBy(['active' => true]);

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);
        
        $search = $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $produit = $produitsRepository->getPaginatedProduits($page, $limit, $search->get('mots')->getData());
            $pages = ceil($produitsRepository->getTotalProduits($search->get('mots')->getData())/$limit);
            /*$produit = $produitsRepository->search(
                $search->get('mots')->getData()
            );
            $pages = 0;*/
        }

        return $this->render('main_produits/index.html.twig', [
            'produits' => $produit,
            'role_user' => $role,
            'page' => $page,
            'pages' => $pages,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorieMain(CategoriesRepository $categoriesRepository, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $config = new ConfigSite();

        $user = $this->getUser();
        $role = $user->getRoles()[0];

        // on definit le nombre de d'elements par page
        $limit = $config->getNb_prod();

        $page = (int)$request->query->get("page", 1);

        $categories = $categoriesRepository->findAll();
        $categorie = $categoriesRepository->findAll()[0];

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);

        $search = $form->handleRequest($request);

        $produit = $produitsRepository->getPaginatedProduitsCategorie($categorie, $page, $limit);
        $pages = ceil($produitsRepository->getTotalProduitsCategorie($categorie)/$limit);

        //$produit = $produitsRepository->findBy(['active' => true, 'categories' => $categorie]);

        
        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $produit = $produitsRepository->getPaginatedProduitsCategorie($categorie, $page, $limit, $search->get('mots')->getData());
            $pages = ceil($produitsRepository->getTotalProduitsCategorie($categorie, $search->get('mots')->getData())/$limit);
            /*$produit = $produitsRepository->search(
                $search->get('mots')->getData(),
                $categorie
            );
            $pages = 0;*/
        }

        return $this->render('main_produits/categorie.html.twig', [
            'produits' => $produit,
            'categories' => $categories,
            'categorie_id' => $categorie->getId(),
            'role_user' => $role,
            'page' => $page,
            'pages' => $pages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie_id", methods={"GET", "POST"})
     */
    public function categorie(Categories $categorie, CategoriesRepository $categoriesRepository, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $config = new ConfigSite();

        $user = $this->getUser();
        $role = $user->getRoles()[0];

        // on definit le nombre de d'elements par page
        $limit = $config->getNb_prod();

        $page = (int)$request->query->get("page", 1);

        $categories = $categoriesRepository->findAll();

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);

        $search = $form->handleRequest($request);

        $produit = $produitsRepository->getPaginatedProduitsCategorie($categorie, $page, $limit);
        $pages = ceil($produitsRepository->getTotalProduitsCategorie($categorie)/$limit);

        //$produit = $produitsRepository->findBy(['active' => true, 'categories' => $categorie]);

        
        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $produit = $produitsRepository->search(
                $search->get('mots')->getData(),
                $categorie
            );
        }

        return $this->render('main_produits/categorie.html.twig', [
            'produits' => $produit,
            'categories' => $categories,
            'categorie_id' => $categorie->getId(),
            'role_user' => $role,
            'page' => $page,
            'pages' => $pages,
            'form' => $form->createView(),
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
