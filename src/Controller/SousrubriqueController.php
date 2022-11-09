<?php

namespace App\Controller;

use App\Entity\Sousrubrique;
use App\Form\SousrubriqueType;
use App\Repository\DossierRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SousrubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/sousrubrique')]
class SousrubriqueController extends AbstractController
{
    #[Route('/', name: 'app_sousrubrique_index', methods: ['GET'])]
    public function index(SousrubriqueRepository $sousrubriqueRepository): Response
    {
        return $this->render('admin/sousrubrique/index.html.twig', [
            'sousrubriques' => $sousrubriqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sousrubrique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SousrubriqueRepository $sousrubriqueRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $sousrubrique = new Sousrubrique();
        $id_rubrique = $_GET['id_rubrique'];
        $form = $this->createForm(SousrubriqueType::class, $sousrubrique);
        $form->handleRequest($request);
        $rubrique = $sousrubrique->getRubrique();
        $rubrique = $rubriqueRepository->find($id_rubrique);
        $dossier = $rubrique->getDossier();

        if ($form->isSubmitted() && $form->isValid()) {
            //On ajoute la rubrique
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $sousrubrique->setRubrique($rubrique);
            $sousrubriqueRepository->add($sousrubrique);

            //on récupère le dossier
            $dossier = $rubrique->getDossier();
            
            //return $this->redirectToRoute('app_dossier_show', ['id' => $id_dossier], Response::HTTP_SEE_OTHER);
            return $this->render('admin/rubrique/show.html.twig', [
                'rubrique' => $rubrique,
                'dossier' => $dossier

            ]);
        }

        return $this->renderForm('admin/sousrubrique/new.html.twig', [
            'sousrubrique' => $sousrubrique,
            'form' => $form,
            'rubrique' => $rubrique,
            'dossier' => $dossier
        ]);
    }

    #[Route('/{id}', name: 'app_sousrubrique_show', methods: ['GET'])]
    public function show(Sousrubrique $sousrubrique): Response
    {
        $dossier = $sousrubrique->getRubrique()->getDossier();
        return $this->render('admin/sousrubrique/show.html.twig', [
            'sousrubrique' => $sousrubrique,
            'dossier' => $dossier
           
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sousrubrique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sousrubrique $sousrubrique, SousrubriqueRepository $sousrubriqueRepository): Response
    {
        $form = $this->createForm(SousrubriqueType::class, $sousrubrique);
        $form->handleRequest($request);
        $rubrique = $sousrubrique->getRubrique();
        $dossier = $rubrique->getDossier();
        

        if ($form->isSubmitted() && $form->isValid()) {
            $sousrubriqueRepository->add($sousrubrique);
           
            return $this->renderForm('admin/rubrique/show.html.twig', [
                'sousrubrique' => $sousrubrique,
                'rubrique' => $rubrique,
                'form' => $form,
                'dossier' => $dossier
            ]);
        }

        return $this->renderForm('admin/sousrubrique/edit.html.twig', [
            'sousrubrique' => $sousrubrique,
            'rubrique' => $rubrique,
            'form' => $form,
            'dossier' => $dossier
        ]);
    }

    #[Route('/{id}', name: 'app_sousrubrique_delete', methods: ['POST'])]
    public function delete(Request $request, Sousrubrique $sousrubrique, SousrubriqueRepository $sousrubriqueRepository): Response
    {
        $rubrique = $sousrubrique->getRubrique();
        $dossier = $rubrique->getDossier();
        
        if ($this->isCsrfTokenValid('delete'.$sousrubrique->getId(), $request->request->get('_token'))) {
            $sousrubriqueRepository->remove($sousrubrique);
        }

        return $this->render('admin/rubrique/show.html.twig', [
            'rubrique' => $rubrique,
            'dossier' => $dossier
        ]);
        //return $this->redirectToRoute('app_sousrubrique_index', [], Response::HTTP_SEE_OTHER);
    }
}
