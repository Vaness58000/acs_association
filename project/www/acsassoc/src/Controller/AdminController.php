<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="app_admin_")
*/
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(UsersRepository $usersRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $id_user = $user->getId();

        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            "users" => $usersRepository->findAll(),
            'role_user' => $role,
            'id_user' => $id_user,
        ]);
    }

    /**
     * @Route("/users/verified/{id}", name="users_verified")
     */
    public function verified(Users $users): Response
    {
        $users->setVerified(!$users->isVerified());

        $em = $this->getDoctrine()->getManager();
        $em->persist($users);
        $em->flush();

        return new Response("true");
    }


}
