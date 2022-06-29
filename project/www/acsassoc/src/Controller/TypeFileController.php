<?php

namespace App\Controller;

use App\Entity\TypeFile;
use App\Form\TypeFileType;
use App\Repository\TypeFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/file")
 */
class TypeFileController extends AbstractController
{
    /**
     * @Route("/", name="app_type_file_index", methods={"GET"})
     */
    public function index(TypeFileRepository $typeFileRepository): Response
    {
        return $this->render('type_file/index.html.twig', [
            'type_files' => $typeFileRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_file_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeFileRepository $typeFileRepository): Response
    {
        $typeFile = new TypeFile();
        $form = $this->createForm(TypeFileType::class, $typeFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFileRepository->add($typeFile, true);

            return $this->redirectToRoute('app_type_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_file/new.html.twig', [
            'type_file' => $typeFile,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_file_show", methods={"GET"})
     */
    public function show(TypeFile $typeFile): Response
    {
        return $this->render('type_file/show.html.twig', [
            'type_file' => $typeFile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_file_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeFile $typeFile, TypeFileRepository $typeFileRepository): Response
    {
        $form = $this->createForm(TypeFileType::class, $typeFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFileRepository->add($typeFile, true);

            return $this->redirectToRoute('app_type_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_file/edit.html.twig', [
            'type_file' => $typeFile,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_file_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeFile $typeFile, TypeFileRepository $typeFileRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFile->getId(), $request->request->get('_token'))) {
            $typeFileRepository->remove($typeFile, true);
        }

        return $this->redirectToRoute('app_type_file_index', [], Response::HTTP_SEE_OTHER);
    }
}
