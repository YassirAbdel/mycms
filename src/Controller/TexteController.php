<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Texte;
use App\Entity\Upload;
use App\Form\ImageType;
use App\Form\TexteType;
use App\Form\UploadType;
use App\Repository\ArticleRepository;
use App\Repository\DossierRepository;
use App\Repository\ImageRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SousrubriqueRepository;
use App\Repository\TexteRepository;
use App\Repository\UploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/texte')]
class TexteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'app_texte_index', methods: ['GET'])]
    public function index(TexteRepository $texteRepository): Response
    {
        return $this->render('admin/texte/index.html.twig', [
            'textes' => $texteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_texte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DossierRepository $dossierRepository, TexteRepository $texteRepository, RubriqueRepository $rubriqueRepository, SousrubriqueRepository $sousrubriqueRepository, ArticleRepository $articleRepository): Response
    {
        $texte = new Texte();
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($_GET['id_rubrique'])) {
                $id_rubrique = $_GET['id_rubrique'];
                $rubrique = $rubriqueRepository->find($id_rubrique);
                $id_dossier = $rubrique->getDossier()->getId();
                $texte->setRubrique($rubrique);
            }
            if (isset($_GET['id_sous_rubrique'])) {
                $id_sous_rubrique = $_GET['id_sous_rubrique'];
                $sous_rubrique = $sousrubriqueRepository->find($id_sous_rubrique);
                $id_dossier = $sous_rubrique->getRubrique()->getDossier()->getId();
                $rubrique = $sous_rubrique->getRubrique();
                $texte->setSousrubrique($sous_rubrique);
            }
            if (isset($_GET['id_article'])) {
                $id_article = $_GET['id_article'];
                $article = $articleRepository->find($id_article);
                $texte->setArticle($article);
            }
            if (isset($id_dossier)) {
                $dossier = $dossierRepository->find($id_dossier);
            }
            $texteRepository->add($texte);
            
            if (isset($_GET['id_rubrique'])) {
                return $this->render('admin/rubrique/show.html.twig', [
                    'rubrique' => $rubrique,
                    'dossier' => $dossier
                ]);
            }
            if (isset($_GET['id_sous_rubrique'])) {
                return $this->render('admin/rubrique/show.html.twig', [
                    'sousrubrique' => $sous_rubrique,
                    'dossier' => $dossier,
                    'rubrique' => $rubrique
                ]);
            }
            if (isset($_GET['id_article'])) {
                return $this->render('admin/article/show.html.twig', [
                    'article' => $article
                ]);
            }
        }
        if (isset($_GET['id_sous_rubrique'])) {
            $id_sous_rubrique = $_GET['id_sous_rubrique'];
            $sousrubrique = $sousrubriqueRepository->find($id_sous_rubrique);
            $rubrique = $sousrubrique->getRubrique();
            $dossier = $rubrique->getDossier();
            return $this->renderForm('admin/texte/new.html.twig', [
                'texte' => $texte,
                'form' => $form,
                'dossier' => $dossier,
                'rubrique' => $rubrique,
                'sousrubrique' => $sousrubrique
            ]);
        }
        if (isset($_GET['id_rubrique'])) {
            $id_rubrique = $_GET['id_rubrique'];
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $dossier = $rubrique->getDossier(); 
            return $this->renderForm('admin/texte/new.html.twig', [
                'texte' => $texte,
                'form' => $form,
                'dossier' => $dossier,
                'rubrique' => $rubrique
            ]);
        }
        if (isset($_GET['id_article'])) {
            $id_article = $_GET['id_article'];
            $article = $articleRepository->find($id_article);
            return $this->renderForm('admin/texte/new.html.twig', [
                'texte' => $texte,
                'form' => $form,
                'article' => $article,
            ]);
        }

    }

    #[Route('/{id}', name: 'app_texte_show', methods: ['GET'])]
    public function show(Texte $texte): Response
    {
        //dd($texte);
        return $this->render('admin/texte/show.html.twig', [
            'texte' => $texte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_texte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Texte $texte, TexteRepository $texteRepository, SousrubriqueRepository $sousrubriqueRepository, SluggerInterface $slugger, UploadRepository $uploadRepository, ImageRepository $imageRepository): Response
    {
        if (isset($_GET['id_sous_rubrique'])) {
            $id_sous_rubrique = $_GET['id_sous_rubrique'];
            $sous_rubrique = $sousrubriqueRepository->find($id_sous_rubrique);
            $dossier = $sous_rubrique->getRubrique()->getDossier();
            $rubrique = $sous_rubrique->getRubrique();
        }
        if (isset($_GET['id_rubrique'])) {
            $rubrique = $texte->getRubrique();
            $dossier = $rubrique->getDossier();
            //$sous_rubrique = "";
        }
        if (isset($_GET['id_article'])) {
            $article = $texte->getArticle();     
        }
        
        $form = $this->createForm(TexteType::class, $texte);
        $form->handleRequest($request);

        $upload = new Upload();
        $formUpload = $this->createForm(UploadType::class, $upload);
        $formUpload->handleRequest($request);

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImage->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texteRepository->add($texte);
            if (isset($rubrique)) {
                return $this->renderForm('admin/rubrique/show.html.twig', [
                    'rubrique' => $rubrique,
                    'form' => $form,
                    'dossier' => $dossier,
                    'formUpload' => $formUpload,
                    'formImage' => $formImage
                    //'sousrubrique' => $sous_rubrique
                ]);
            }
            if (isset($article)) {
                return $this->renderForm('admin/article/show.html.twig', [
                    'article' => $article,
                    'form' => $form,
                    'formUpload' => $formUpload,
                    'formImage' => $formImage
                ]);
            }
        }

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
          $id_texte = $_POST["texte_id"];
          $titre = $formUpload->get('titre')->getData();
            $uploadFile = $formUpload->get('filename')->getData();
            if ($uploadFile) {
                $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $filesize = filesize($uploadFile);
                //dd($filesize);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();
                try {
                    $uploadFile->move(
                        $this->getParameter('filespdf_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e);
                }
                $texte = $texteRepository->find($id_texte);
                $upload->setTexte($texte);
                $upload->setTitre($titre);
                $upload->setFilename($newFilename);
                $uploadRepository->add($upload);
            }
        }

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            $id_texte = $_POST["texte_id"];
            $texte = $texteRepository->find($id_texte);
            $image->setTexte($texte);
            $imageRepository->add($image);
        }

        if (isset($_GET['id_rubrique']) || isset($_GET['id_sous_rubrique']) ) {
            return $this->renderForm('admin/texte/edit.html.twig', [
                'texte' => $texte,
                'form' => $form,
                'dossier' => $dossier,
                'rubrique' => $rubrique,
                'formUpload' => $formUpload,
                'formImage' => $formImage
                //'sousrubrique' => $sous_rubrique,
            ]);
        }
        if (isset($_GET['id_article'])) {
            return $this->renderForm('admin/texte/edit.html.twig', [
                'texte' => $texte,
                'form' => $form,
                'article' => $article,
                'formUpload' => $formUpload,
                'formImage' => $formImage
            ]);
        }
    }

    #[Route('/{id}', name: 'app_texte_delete', methods: ['POST'])]
    public function delete(Request $request, Texte $texte, TexteRepository $texteRepository, SousrubriqueRepository $sousrubriqueRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $id_sous_rubrique = $request->get('id_sous_rubrique');
        $id_rubrique = $request->get('id_rubrique');
        //dd($id_rubrique);

        if (isset($id_sous_rubrique)) {
            $sous_rubrique = $sousrubriqueRepository->find($id_sous_rubrique);
            $rubrique = $sous_rubrique->getRubrique();
            $dossier = $rubrique->getDossier();
            
        }
        if (isset($id_rubrique)) {
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $dossier = $rubrique->getDossier();
        }
        
        
        
        
        if ($this->isCsrfTokenValid('delete'.$texte->getId(), $request->request->get('_token'))) {
            dd($texte);
            $texteRepository->remove($texte);
        }

        return $this->renderForm('admin/rubrique/show.html.twig', [
            'rubrique' => $rubrique,
            'dossier' => $dossier
            
        ]);
    }

    #[Route('/removeTexte/{id}', name: 'app_remove_texte')]
    public function removeRessourceRubrique(Texte $texte, DossierRepository $dossierRepository, TexteRepository $texteRepository, SousrubriqueRepository $sousrubriqueRepository, RubriqueRepository $rubriqueRepository, ArticleRepository $articleRepository): Response
    {
            $em = $this->entityManager;

            if (isset($_GET['id_sous_rubrique'])) {
                $id_sous_rubrique = $_GET['id_sous_rubrique'];
                $sousrubrique = $sousrubriqueRepository->find($id_sous_rubrique);
                $rubrique = $sousrubrique->getRubrique();
                $dossier = $rubrique->getDossier();
                
                //$sousrubrique->removeTexte($texte);
                //$em->flush();
                if ($this->isCsrfTokenValid('delete'.$texte->getId(), $_GET['_token'])) {
                    $texteRepository->remove($texte);
                }

                return $this->render('admin/rubrique/show.html.twig', [
                    'sousrubrique' => $sousrubrique,
                    'dossier' => $dossier,
                    'rubrique' => $rubrique
                ]);
            }
            if (isset($_GET['id_rubrique'])) {
                $id_rubrique = $_GET['id_rubrique'];
                $rubrique = $rubriqueRepository->find($id_rubrique);
                $dossier = $rubrique->getDossier();
                if ($this->isCsrfTokenValid('delete'.$texte->getId(), $_GET['_token'])) {
                    $texteRepository->remove($texte);
                }
                return $this->render('admin/rubrique/show.html.twig', [
                    'rubrique' => $rubrique,
                    'dossier' => $dossier
                ]);
            }
            if (isset($_GET['id_article'])) {
                $id_article = $_GET['id_article'];
                $article = $articleRepository->find($id_article);
                
                if ($this->isCsrfTokenValid('delete'.$texte->getId(), $_GET['_token'])) {
                    $texteRepository->remove($texte);
                }
                return $this->render('admin/article/show.html.twig', [
                    'article' => $article,
                ]);
            }
    }
    
}
