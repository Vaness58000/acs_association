<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchDateIntervalType;
use App\ClassMain\ConfigSite;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="app_categories_index", methods={"GET"})
     */
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
        $config = new ConfigSite();

        $user = $this->getUser();
        $role = $user->getRoles()[0];

        // on definit le nombre de d'elements par page
        $limit = $config->getNb_row();

        $page = (int)$request->query->get("page", 1);
        $isAdmin = $request->query->get("admin", "user") == "admin" ? true : false;

        $categories = $categoriesRepository->getPaginatedCategorie($page, $limit);
        $pages = ceil($categoriesRepository->getTotalCategorie()/$limit);

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'role_user' => $role,
            'page' => $page,
            'pages' => $pages,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * @Route("/new", name="app_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $isAdmin = $request->query->get("admin", "user") == "admin" ? true : false;

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
            'isAdmin' => $isAdmin,
        ]);
    }

    private function createTabGraph($produits) {
        $produitsDate = [];
        $produitsDate['dates'] = [];
        $produitsDate['count'] = [];

        $categories_produit = [];
        foreach ($produits as $produit) {
            $categories_produit[] = $produit['categorie_name'];
        }

        $categories_produit = array_values(array_unique($categories_produit));

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($produits as $produit){
            $produitsDate['dates'][] = $produit['dateProduits'];
            $produitsDate['count'][] = $produit['count'];
            $produitsDate['categorie'][] = $produit['categorie_name'];
        }

        $tabDate = array_values(array_unique($produitsDate['dates']));
        sort($tabDate);

        for ($i=0; $i < count($categories_produit); $i++) { 
            $name = $categories_produit[$i];
            $date = $tabDate;
            $count = array_fill(0, count($date), 0);
            $color = "";
            foreach ($produits as $produit) {
                if($produit['categorie_name'] == $name) {
                    for ($j=0; $j < count($date) ; $j++) { 
                        if($date[$j] == $produit['dateProduits']) {
                            $count[$j] += $produit['count'];
                        }
                    }
                    $color = $produit['color'];
                }
            }
            $value = [
                'label' => $name,
                'data' => $count,
                'borderColor' => $color,
            ];
            $categories_produit[$i] = $value;
        }

        $categories_produit_data = [];
        $categories_produit_data['date'][] = $tabDate;
        $categories_produit_data['datas'][] = $categories_produit;
        return $categories_produit_data;
    }

    /**
     * test la date
     */
    private function testDate($date, $from = null, $to = null): bool
    {
        if(!empty($from)) {
            if($date < $from) {
                return false;
            }
        }
        if(!empty($to)) {
            if($date > $to) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Route("/stats", name="app_categories_stats")
     */
    public function statistiques(CategoriesRepository $categoriesRepository, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $form = $this->createForm(SearchDateIntervalType::class, null, [
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);

        $search = $form->handleRequest($request);

        $categories = $categoriesRepository->selectInterval();
        $produits = $produitsRepository->countByDate();
        $produits2 = $produitsRepository->countPriceByDate();


        $start = null;
        $end = null;

        if($form->isSubmitted() && $form->isValid()){
            $start = $search->get('start')->getData();
            $end = $search->get('end')->getData();
            $categories = $categoriesRepository->selectInterval($start, $end);
            $produits = $produitsRepository->countByDate($start, $end);
            $produits2 = $produitsRepository->countPriceByDate($start, $end);
        }

        $categoriesJson = [];
        $categoriesJson['name'] = [];
        $categoriesJson['color'] = [];
        $categoriesJson['count'] = [];
        $categoriesJson['price'] = [];

        foreach ($categories as $categorie) {
            $categoriesJson['name'][] = $categorie->getName();
            $categoriesJson['color'][] = $categorie->getColor();
            $priceTotal = 0;
            $count = 0;
            foreach ($categorie->getProduits() as $produit) {
                if($this->testDate($produit->getAchatAt(), $start, $end)) {
                    $priceTotal += $produit->getPrice();
                    $count++;
                }
            }
            $categoriesJson['price'][] = $priceTotal;
            $categoriesJson['count'][] = $count;
        }

        // On va chercher le nombre d'annonces publiées par date
        $categories_produit_data = $this->createTabGraph($produits);
        $categories_produit_data2 = $this->createTabGraph($produits2);
        

        return $this->render('categories/stats.html.twig', [
            'categoriesJson' => json_encode($categoriesJson),
            'produitsJson' => json_encode($categories_produit_data),
            'produitsJson2' => json_encode($categories_produit_data2),
            'role_user' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_categories_show", methods={"GET"})
     */
    public function show(Categories $category, Request $request): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        
        $isAdmin = $request->query->get("admin", "user") == "admin" ? true : false;

        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'role_user' => $role,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        
        $isAdmin = $request->query->get("admin", "user") == "admin" ? true : false;

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
            'isAdmin' => $isAdmin,
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
