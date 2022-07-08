<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Entity\Images;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produits")
 */
class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="app_produits_index", methods={"GET"})
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('produits/index.html.twig', [
            'produits' => $user->getProduits(),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/new", name="app_produits_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProduitsRepository $produitsRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On récupère le manuel transmise
            $manuel = $form->get('manuel_src')->getData();
            if(!empty($manuel) && !empty($manuel->getClientOriginalName())) {
                //On génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $manuel->guessExtension();
                //On va copier le fichier dans le dossier uploads
                $manuel->move(
                    $this->getParameter('files_directory'),
                    $fichier
                );
                $produit->setManuelSrc($fichier);
            }


            // On récupère le ticket transmise
            $ticket = $form->get('ticket_src')->getData();
            if(!empty($ticket) && !empty($ticket->getClientOriginalName())) {
                //On génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $ticket->guessExtension();
                //On va copier le fichier dans le dossier uploads
                $ticket->move(
                    $this->getParameter('files_directory'),
                    $fichier
                );
                $produit->setTicketSrc($fichier);
            }

            $produit->setActive(true);
            $produit->setUsers($this->getUser());

            //On boucle sur les images
            foreach($images as $image){
                //On génére un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //On va copier le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                //On stock image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $img->setSrc($fichier);
                $produit->addImage($img);
            }

            $produit->setUsers($this->getUser());
            $produitsRepository->add($produit, true);

            return $this->redirectToRoute('app_produits_index', [
                'role_user' => $role,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/testEndProduit", name="testEndProduit")
     */
    public function testEndGarantee(ProduitsRepository $produitsRepository){

        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $endproduit = $produitsRepository->end_garantee();

        dd($endproduit);

        return $this->render('produits/test.html.twig', [
            'endproduit' => $endproduit,
            'role_user' => $role,
        ]);
        
    }

    /**
     * @Route("/{id}", name="app_produits_show", methods={"GET"})
     */
    public function show(Produits $produit): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_produits_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                      // On récupère les images transmises
                      $images = $form->get('images')->getData();

                      //On boucle sur les images
                      foreach($images as $image){
                          //On génére un nouveau nom de fichier
                          $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                          //On va copier le fichier dans le dossier uploads
                          $image->move(
                              $this->getParameter('images_directory'),
                              $fichier
                          );
          
                          //On stock image dans la base de données (son nom)
                          $img = new Images();
                          $img->setName($fichier);
                          $img->setSrc($fichier);
                          $produit->addImage($img);
                      }
           // On récupère le manuel transmise
           $manuel = $form->get('manuel_src')->getData();
           if(!empty($manuel) && !empty($manuel->getClientOriginalName())) {
               //On génére un nouveau nom de fichier
               $fichier = md5(uniqid()) . '.' . $manuel->guessExtension();
               //On va copier le fichier dans le dossier uploads
               $manuel->move(
                   $this->getParameter('files_directory'),
                   $fichier
               );
               $produit->setManuelSrc($fichier);
           }


           // On récupère le ticket transmise
           $ticket = $form->get('ticket_src')->getData();
           if(!empty($ticket) && !empty($ticket->getClientOriginalName())) {
               //On génére un nouveau nom de fichier
               $fichier = md5(uniqid()) . '.' . $ticket->guessExtension();
               //On va copier le fichier dans le dossier uploads
               $ticket->move(
                   $this->getParameter('files_directory'),
                   $fichier
               );
               $produit->setTicketSrc($fichier);
           }

            $produit->setUsers($this->getUser());
            $produitsRepository->add($produit, true);

            return $this->redirectToRoute('app_produits_index', [
                'role_user' => $role,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="app_produits_delete", methods={"POST"})
     */
    public function delete(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitsRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produits_index', [
            'role_user' => $role,
        ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="produits_delete_image", methods={"GET", "DELETE"})
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

     /**
     * @Route("/supprime/manuel/{id}", name="produits_delete_manuel", methods={"GET", "DELETE"})
     */
    public function deleteManuel(Produits $produit, ProduitsRepository $produitsRepository, Request $request){
        unlink($this->getParameter('files_directory').'/'.$produit->getManuelSrc()); //unlink=pour supprimer un fichier 
        $produit->setManuelSrc(""); //retire le nom de la src dans la bdd
        $produitsRepository->add($produit, true); // ça fait la midification dans la bdd
       
        return new JsonResponse(['success' => 1]);
    }
    
    /**
     * @Route("/supprime/ticket/{id}", name="produits_delete_ticket", methods={"GET", "DELETE"})
     */
    public function deleteTicket(Produits $produit, ProduitsRepository $produitsRepository, Request $request){
        unlink($this->getParameter('files_directory').'/'.$produit->getTicketSrc()); //unlink=pour supprimer un fichier 
        $produit->setTicketSrc(""); //retire le nom de la src dans la bdd
        $produitsRepository->add($produit, true); // ça fait la midification dans la bdd
        
        return new JsonResponse(['success' => 1]);
    }
}
