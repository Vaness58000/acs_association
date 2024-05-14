<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\ClassMain\ConfigSite;

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
    public function users(UsersRepository $usersRepository, Request $request): Response
    {
        $config = new ConfigSite();

        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $id_user = $user->getId();

        // on definit le nombre de d'elements par page
        $limit = $config->getNb_row();

        $page = (int)$request->query->get("page", 1);

        $users = $usersRepository->getPaginatedUsersAdmin($page, $limit);
        $pages = ceil($usersRepository->getTotalUsersAdmin()/$limit);

        $tabUsers = [];
        
        foreach ($users as $value) {
            if($id_user != $value->getId()) {
                $tabUsers[] = $value;
            }
        }

        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            "users" => $tabUsers,
            'role_user' => $role,
            'id_user' => $id_user,
            'page' => $page,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/users/verified/{id}", name="users_verified")
     */
    public function verified(Users $users): Response
    {
        $users->setIsVerified(!$users->isVerified());

        $em = $this->getDoctrine()->getManager();
        $em->persist($users);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/users/role/{id}/{role}", name="users_verified")
     */
    public function role(Users $users, ?string $role): Response
    {
        $users->setRoles([$role]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($users);
        $em->flush();

        return new Response("true");
    }


}
