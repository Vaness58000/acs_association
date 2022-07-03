<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        if(!empty($this->getUser())) {
            return $this->redirectToRoute('app_main_produits_index');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
