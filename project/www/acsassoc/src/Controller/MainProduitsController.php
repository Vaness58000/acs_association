<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;
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
     * @Route("/categorie/{id}", name="categorie", methods={"GET"})
     */
    public function categorie(Categories $categorie): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('main_produits/index.html.twig', [
            'produits' => $categorie->getProduits(),
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
