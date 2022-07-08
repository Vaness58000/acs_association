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
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $produit = $produitsRepository->findBy(['active' => true]);

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);
        
        $search = $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $produit = $produitsRepository->search(
                $search->get('mots')->getData()
            );
        }

        return $this->render('main_produits/index.html.twig', [
            'produits' => $produit,
            'role_user' => $role,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorieMain(CategoriesRepository $categoriesRepository, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $categories = $categoriesRepository->findAll();
        $categorie = $categoriesRepository->findAll()[0];

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);

        $search = $form->handleRequest($request);

        $produit = $produitsRepository->findBy(['active' => true, 'categories' => $categorie]);

        
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
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie_id", methods={"GET", "POST"})
     */
    public function categorie(Categories $categorie, CategoriesRepository $categoriesRepository, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $categories = $categoriesRepository->findAll();

        $form = $this->createForm(SearchProduitsType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);

        $search = $form->handleRequest($request);

        $produit = $produitsRepository->findBy(['active' => true, 'categories' => $categorie]);

        
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
