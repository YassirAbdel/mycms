<?php

namespace App\Controller;

use App\Entity\Souscollectioncnd;
use App\Form\SouscollectioncndType;
use App\Form\SouscollectioncndUpdateType;
use App\Repository\CollectioncndRepository;
use App\Repository\SouscollectioncndRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/souscollection')]
class SouscollectioncndController extends AbstractController
{
    #[Route('/', name: 'app_souscollectioncnd_index', methods: ['GET'])]
    public function index(SouscollectioncndRepository $souscollectioncndRepository): Response
    {
        return $this->render('admin/souscollectioncnd/index.html.twig', [
            'souscollectioncnds' => $souscollectioncndRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_souscollectioncnd_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SouscollectioncndRepository $souscollectioncndRepository, CollectioncndRepository $collectioncndRepository): Response
    {
        $souscollectioncnd = new Souscollectioncnd();
        $id_collection = $_GET['id_collection'];
        $form = $this->createForm(SouscollectioncndType::class, $souscollectioncnd);
        $form->handleRequest($request);
        $collection = $collectioncndRepository->find($id_collection);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $collection = $collectioncndRepository->find($id_collection);
            $souscollectioncnd->setCollectioncnd($collection);
            $souscollectioncndRepository->add($souscollectioncnd);
            return $this->redirectToRoute('app_souscollectioncnd_show', ['id' => $souscollectioncnd->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/souscollectioncnd/new.html.twig', [
            'souscollectioncnd' => $souscollectioncnd,
            'form' => $form,
            'collection' => $collection
        ]);
    }

    #[Route('/{id}', name: 'app_souscollectioncnd_show', methods: ['GET'])]
    public function show(Souscollectioncnd $souscollectioncnd): Response
    {
        $collection = $souscollectioncnd->getCollectioncnd();
        return $this->render('admin/souscollectioncnd/show.html.twig', [
            'souscollectioncnd' => $souscollectioncnd,
            'collection' => $collection 
        ]);
    }

    #[Route('/{id}/edit', name: 'app_souscollectioncnd_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souscollectioncnd $souscollectioncnd, SouscollectioncndRepository $souscollectioncndRepository): Response
    {
        $form = $this->createForm(SouscollectioncndUpdateType::class, $souscollectioncnd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $souscollectioncndRepository->add($souscollectioncnd);
            return $this->redirectToRoute('app_souscollectioncnd_show', ['id' => $souscollectioncnd->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/souscollectioncnd/edit.html.twig', [
            'souscollectioncnd' => $souscollectioncnd,
            'form' => $form,
        ]);
    }

    #[Route('/remove/{id}', name: 'app_souscollectioncnd_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Souscollectioncnd $souscollectioncnd, SouscollectioncndRepository $souscollectioncndRepository): Response
    {
        $collection = $souscollectioncnd->getCollectioncnd();
        //if ($this->isCsrfTokenValid('delete'.$souscollectioncnd->getId(), $request->request->get('_token'))) {
            $souscollectioncndRepository->remove($souscollectioncnd);
        //}

        return $this->redirectToRoute('app_collectioncnd_show', ['id' => $collection->getId()], Response::HTTP_SEE_OTHER);
    }
}
