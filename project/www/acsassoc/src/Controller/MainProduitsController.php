<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;

class MainProduitsController extends AbstractController
{
    /**
     * @Route("/main/produits", name="app_main_produits")
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('main_produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }
}
