<?php

namespace App\Controller;

use App\Entity\Collectioncnd;
use App\Form\CollectioncndType;
use App\Repository\CollectioncndRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/collections')]
class CollectioncndController extends AbstractController
{
    #[Route('/', name: 'app_collectioncnd_index', methods: ['GET'])]
    public function index(CollectioncndRepository $collectioncndRepository): Response
    {
        return $this->render('admin/collectioncnd/index.html.twig', [
            'collectioncnds' => $collectioncndRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collectioncnd_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectioncndRepository $collectioncndRepository): Response
    {
        $collectioncnd = new Collectioncnd();
        $form = $this->createForm(CollectioncndType::class, $collectioncnd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectioncnd->setType(3);
            $collectioncndRepository->add($collectioncnd);
            return $this->redirectToRoute('app_collectioncnd_show', ['id' => $collectioncnd->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collectioncnd/new.html.twig', [
            'collectioncnd' => $collectioncnd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collectioncnd_show', methods: ['GET'])]
    public function show(Collectioncnd $collectioncnd): Response
    {
        return $this->render('admin/collectioncnd/show.html.twig', [
            'collectioncnd' => $collectioncnd,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collectioncnd_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collectioncnd $collectioncnd, CollectioncndRepository $collectioncndRepository): Response
    {
        $form = $this->createForm(CollectioncndType::class, $collectioncnd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            ///dd($collectioncnd);
            $collectioncndRepository->add($collectioncnd);
            return $this->redirectToRoute('app_collectioncnd_show', ['id' => $collectioncnd->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collectioncnd/edit.html.twig', [
            'collectioncnd' => $collectioncnd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collectioncnd_delete', methods: ['POST'])]
    public function delete(Request $request, Collectioncnd $collectioncnd, CollectioncndRepository $collectioncndRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectioncnd->getId(), $request->request->get('_token'))) {
            $collectioncndRepository->remove($collectioncnd);
        }

        return $this->redirectToRoute('app_collectioncnd_index', [], Response::HTTP_SEE_OTHER);
    }
}
