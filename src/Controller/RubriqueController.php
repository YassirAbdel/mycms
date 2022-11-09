<?php

namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\DossierRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/rubrique')]
class RubriqueController extends AbstractController
{
    #[Route('/', name: 'app_rubrique_index', methods: ['GET'])]
    public function index(RubriqueRepository $rubriqueRepository): Response
    {
        return $this->render('admin/rubrique/index.html.twig', [
            'rubriques' => $rubriqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rubrique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RubriqueRepository $rubriqueRepository, DossierRepository $dossierRepository): Response
    {
        $rubrique = new Rubrique();
        $id_dossier = $_GET['id_dossier'];
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);
        $dossier = $dossierRepository->find($id_dossier);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier = $dossierRepository->find($id_dossier);
            $rubrique->setDossier($dossier);
            $rubriqueRepository->add($rubrique);
            //return $this->redirectToRoute('app_rubrique_show', ['id' => $rubrique->getId()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_rubrique_show', ['id' => $rubrique->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/rubrique/new.html.twig', [
            'rubrique' => $rubrique,
            'form' => $form,
            'dossier' => $dossier
        ]);
    }

    #[Route('/{id}', name: 'app_rubrique_show', methods: ['GET'])]
    public function show(Rubrique $rubrique): Response
    {
        $dossier = $rubrique->getDossier();
        
        return $this->render('admin/rubrique/show.html.twig', [
            'rubrique' => $rubrique,
            'dossier' => $dossier
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rubrique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rubrique $rubrique, RubriqueRepository $rubriqueRepository): Response
    {
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);
        $dossier = $rubrique->getDossier();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $rubriqueRepository->add($rubrique);
            $dossier = $dossier;
            //return $this->redirectToRoute('app_rubrique_index', [], Response::HTTP_SEE_OTHER);
            return $this->renderForm('admin/rubrique/show.html.twig', [
                'rubrique' => $rubrique,
                'form' => $form,
                'dossier' => $dossier
            ]);
        }
        
        return $this->renderForm('admin/rubrique/edit.html.twig', [
            'rubrique' => $rubrique,
            'form' => $form,
            'dossier' => $dossier
        ]);
    }

    #[Route('/{id}', name: 'app_rubrique_delete', methods: ['POST'])]
    public function delete(Request $request, Rubrique $rubrique, RubriqueRepository $rubriqueRepository): Response
    {
        $dossier = $rubrique->getDossier();
        $rubriques = $dossier->getRubriques();
        

        if ($this->isCsrfTokenValid('delete'.$rubrique->getId(), $request->request->get('_token'))) {
            $rubriqueRepository->remove($rubrique);
            
        }

        //return $this->redirectToRoute('app_rubrique_index', [], Response::HTTP_SEE_OTHER);
        return $this->render('admin/dossier/show_init.html.twig', [
            'dossier' => $dossier,
            'rubriques' => $rubriques
        ]);
    }

    
}
