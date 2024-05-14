<?php

namespace App\Controller;

use App\Entity\AddFiles;
use App\Form\AddFilesType;
use App\Repository\AddFilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/add/files")
 */
class AddFilesController extends AbstractController
{
    /**
     * @Route("/", name="app_add_files_index", methods={"GET"})
     */
    public function index(AddFilesRepository $addFilesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('add_files/index.html.twig', [
            'add_files' => $addFilesRepository->findAll(),
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/new", name="app_add_files_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AddFilesRepository $addFilesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $addFile = new AddFiles();
        $form = $this->createForm(AddFilesType::class, $addFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addFilesRepository->add($addFile, true);

            return $this->redirectToRoute('app_add_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('add_files/new.html.twig', [
            'add_file' => $addFile,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="app_add_files_show", methods={"GET"})
     */
    public function show(AddFiles $addFile): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        return $this->render('add_files/show.html.twig', [
            'add_file' => $addFile,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_add_files_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AddFiles $addFile, AddFilesRepository $addFilesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        $form = $this->createForm(AddFilesType::class, $addFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addFilesRepository->add($addFile, true);

            return $this->redirectToRoute('app_add_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('add_files/edit.html.twig', [
            'add_file' => $addFile,
            'form' => $form,
            'role_user' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="app_add_files_delete", methods={"POST"})
     */
    public function delete(Request $request, AddFiles $addFile, AddFilesRepository $addFilesRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];

        if ($this->isCsrfTokenValid('delete'.$addFile->getId(), $request->request->get('_token'))) {
            $addFilesRepository->remove($addFile, true);
        }

        return $this->redirectToRoute('app_add_files_index', [
            'role_user' => $role,
        ], Response::HTTP_SEE_OTHER);
    }
}
