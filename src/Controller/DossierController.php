<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\DossierType;
use App\Repository\DossierRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SousrubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/dossier')]
class DossierController extends AbstractController
{
    #[Route('/', name: 'app_dossier_index', methods: ['GET'])]
    public function index(DossierRepository $dossierRepository, SessionInterface $session): Response
    {
        $dossiers = $dossierRepository->findAll();
        
        return $this->render('admin/dossier/index.html.twig', [
            'dossiers' => $dossiers
        ]);
    }

    #[Route('/new', name: 'app_dossier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DossierRepository $dossierRepository, RubriqueRepository $rubriqueRepository, Session $session): Response
    {
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setType(1);
            $dossierRepository->add($dossier);
            $rubriques = $rubriqueRepository->findByidDossier($dossier->getId());
            return $this->render('admin/dossier/show_init.html.twig', [
                'rubriques' => $rubriques,
                'dossier' => $dossier
            ]);
        }
        
        return $this->renderForm('admin/dossier/new.html.twig', [
            'controller_name' => 'DossierController',
            'dossier' => $dossier,
            'form' => $form
        ]);
        
    }

    #[Route('/{id}', name: 'app_dossier_show', methods: ['GET'])]
    public function show(Dossier $dossier, DossierRepository $dossierRepository, RubriqueRepository $rubriqueRepository, SousrubriqueRepository $sousrubriqueRepository): Response
    {
        /**
        $rubriques = $dossierRepository->findByIdDossier($dossier->getId());
        foreach ($rubriques as $rubrique ) {
            $plan[] = $rubriqueRepository->findByidDossier($dossier->getId()); 
            
        }
        */
        $rubriques = $rubriqueRepository->findByidDossier($dossier->getId());
        return $this->render('admin/dossier/show_init.html.twig', [
            'rubriques' => $rubriques,
            'dossier' => $dossier
        ]);
        /**
        if (!isset($plan[0])) {
            return $this->render('admin/dossier/show_init.html.twig', [
                'dossier' => $dossier
            ]);
        } else {
            return $this->render('admin/dossier/show.html.twig', [
                'dossier' => $dossier,
                'plan' => $plan
            ]);
        }
        **/
    }

    #[Route('/{id}/edit', name: 'app_dossier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response
    {
        ($dossier);
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setType(1);
            $rubriques = $dossier->getRubriques();
            $dossierRepository->add($dossier);
          
            return $this->render('admin/dossier/show_init.html.twig', [
                'rubriques' => $rubriques,
                'dossier' => $dossier
            ]);
        }
        
        return $this->renderForm('admin/dossier/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    
    }

    #[Route('/{id}', name: 'app_dossier_delete', methods: ['POST'])]
    public function delete(Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossier->getId(), $request->request->get('_token'))) {
            $dossierRepository->remove($dossier);
        }

        return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
    }
}
