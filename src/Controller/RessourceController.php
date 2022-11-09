<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\CollectioncndRepository;
use App\Repository\DossierRepository;
use App\Repository\RessourceRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SouscollectioncndRepository;
use App\Repository\SousrubriqueRepository;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Classe\Search;
use App\Entity\Souscollectioncnd;
use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('admin/ressources')]
class RessourceController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_ressource_index')]
    
    public function index(Session $session, Request $request, RessourceRepository $ressourceRepository, RubriqueRepository $rubriqueRepository, SouscollectioncndRepository $souscollectioncndRepository, ArticleRepository $articleRepository, PaginatorInterface $paginator)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
      
        // écoute la requête prévoir si le formulaire a été soumis
        $form->handleRequest($request);
        //$id_sous_rubrique = $request->get('idsousrubrique', null);
        $id_texte = $search->getIdtexte();
        $id_rubrique = $search->getIdrubrique();
        $id_collection = $search->getIdcollection();
        $id_sous_collection = $search->getIdsouscollection();
        $id_article = $search->getIdarticle();
        $stringSearch = $search->getString();
       
        
        // On declare les variables de navigation dans la recherche
        $session->remove('idtexte','idrubrique','idsousrubrique','idcollection','idsouscollection','idarticle');
        $session->set('idtexte', $id_texte);
        
        if (isset($id_rubrique)) {
            $session->set('idrubrique', $id_rubrique);
        }
        if (isset($id_sous_rubrique)) {
            $session->set('idsousrubrique', $id_sous_rubrique);
        }
        if (isset($id_collection)) {
            $session->set('idcollection', $id_collection);
        }
        if (isset($id_sous_collection)) {
            $session->set('idsouscollection', $id_sous_collection);
        }
        if (isset($id_article)) {
            $session->set('idarticle', $id_article);
        }
        if (isset($_GET['id_rubrique']) && empty($search->getString())) {
            $id_rubrique = $_GET['id_rubrique'];
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $dossier = $rubrique->getDossier();
            $query = $ressourceRepository->findAll();
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );
            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'resources',
                'ressources' => $ressources,
                'rubrique' => $rubrique,
                'dossier' => $dossier,
                'form' => $form->createView()
            ]);
        }
        if (isset($_GET['id_sous_collection']) && empty($stringSearch) ){
            $id_sous_collection = $_GET['id_sous_collection'];
            $souscollection = $souscollectioncndRepository->find($id_sous_collection);
            $collection = $souscollection->getCollectioncnd();
            $query = $ressourceRepository->findAll();
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );
            
            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'resources',
                'ressources' => $ressources,
                'souscollection' => $souscollection,
                'collection' => $collection,
                'form' => $form->createView()
            ]);
        }
        if (isset($_GET['id_article']) && empty($stringSearch)) {
            $id_article = $_GET['id_article'];
            $article = $articleRepository->find($id_article);
            $query = $ressourceRepository->findAll();
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );
            
            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'resources',
                'ressources' => $ressources,
                'article' => $article,
                'form' => $form->createView()
            ]);
        }
        if (isset($id_rubrique) & isset($stringSearch))  {
        // On vérifie que le formulaire est valide 
        //if ($form->isSubmitted() && $form->isValid()) {
        //}
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $dossier = $rubrique->getDossier();    
            $query = $ressourceRepository->findWithSearch($search);
            $session->set('ressources', $query);
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );
            
            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'ressources',
                'ressources' => $ressources,
                'rubrique' => $rubrique,
                'dossier' => $dossier,
                'form' => $form->createView()
            ]);
        }
        if (isset($id_collection) && isset($stringSearch)) {
            $souscollection = $souscollectioncndRepository->find($id_sous_collection);
            $collection = $souscollection->getCollectioncnd();
            $query = $ressourceRepository->findWithSearch($search);
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );

            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'resources',
                'ressources' => $ressources,
                'souscollection' => $souscollection,
                'collection' => $collection,
                'form' => $form->createView()
            ]);
        }
        if (isset($id_article) && isset($stringSearch)) {
            $article = $articleRepository->find($id_article);
            $query = $ressourceRepository->findWithSearch($search);
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                12
            );

            return $this->render('admin/ressource/index.html.twig', [
                'current_page' => 'resources',
                'ressources' => $ressources,
                'article' => $article,
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RessourceRepository $ressourceRepository, TexteRepository $texteRepository): Response
    {
        $ressource = new Ressource();
        
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($_GET['id_texte'])) {
                $id_texte = $_GET['id_texte'];
                $texte = $texteRepository->find($id_texte);
                $ressource->addTexte($texte);
                $ressourceRepository->add($ressource);
                $sousrubrique = $texte->getSousrubrique();
                //return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
                return $this->renderForm('admin/sousrubrique/show.html.twig', [
                    'sousrubrique' => $sousrubrique,
                    'form' => $form,
                ]);
            }
        }
        
     
        return $this->renderForm('admin/ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
        return $this->render('admin/ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, RessourceRepository $ressourceRepository): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ressourceRepository->add($ressource);
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, RessourceRepository $ressourceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ressource->getId(), $request->request->get('_token'))) {
            $ressourceRepository->remove($ressource);
        }

        return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/addRessourceToTexte/{id}', name: 'app_add_ressource_texte')]
    public function addRessourceRubrique(Ressource $ressource, DossierRepository $dossierRepository,  RessourceRepository $ressourceRepository, TexteRepository $texteRepository, SousrubriqueRepository $sousrubriqueRepository, RubriqueRepository $rubriqueRepository, ArticleRepository $articleRepository): Response
    {
            if (isset($_GET['id_texte'])) {
                $id_texte = $_GET['id_texte'];
                $texte = $texteRepository->find($id_texte);
                $ressource->addTexte($texte);
                $ressourceRepository->add($ressource);
                
                if (isset($_GET['id_sous_rubrique'])) {
                    $id_sous_rubrique = $_GET['id_sous_rubrique'];
                    $sous_rubrique = $sousrubriqueRepository->find($id_sous_rubrique);
                    $id_dossier = $sous_rubrique->getRubrique()->getDossier()->getId();
                    $dossier = $dossierRepository->find($id_dossier);
                    return $this->render('admin/sousrubrique/show.html.twig', [
                        'sousrubrique' => $sous_rubrique,
                        'dossier' => $dossier
                    ]);
                }
                if (isset($_GET['id_rubrique'])) {
                    $id_rubrique = $_GET['id_rubrique'];
                    $rubrique = $rubriqueRepository->find($id_rubrique);
                    $id_dossier = $rubrique->getDossier()->getId();
                    $dossier = $dossierRepository->find($id_dossier);
                    return $this->render('admin/rubrique/show.html.twig', [
                        'rubrique' => $rubrique,
                        'dossier' => $dossier
                    ]);
                }
                if (isset($_GET['id_article'])) {
                    $id_article = $_GET['id_article'];
                    $article = $articleRepository->find($id_article);
                    return $this->render('admin/article/show.html.twig', [
                        'article' => $article
                    ]);
                }
        }        
    }

    #[Route('/addRessourcesToTexte/{id}', name: 'app_add_ressources_texte')]
    public function addRessourcesToTexte (SessionInterface $session, Request $request, Ressource $ressource, TexteRepository $texteRepository, RessourceRepository $ressourceRepository, RubriqueRepository $rubriqueRepository, DossierRepository $dossierRepository, ArticleRepository $articleRepository ,PaginatorInterface $paginator, CollectioncndRepository $collectioncndRepository, SouscollectioncndRepository $souscollectioncndRepository) 
    {
        //$session->clear();
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        
        // écoute la requête pr voir si le formulaire a été soumis
        $form->handleRequest($request);

        if (isset($_GET['id_rubrique'])) {
            $id_rubrique = $_GET['id_rubrique'];
        }
        if (isset($_GET['idrubrique'])) {
            $id_rubrique = $_GET['idrubrique'];
        }
        if (isset($_GET['id_texte'])) {
            $id_texte = $_GET['id_texte'];
            $session->set('id_texte', $id_texte);
        }
        if (isset($_GET['idtexte'])) {
            $id_texte = $_GET['idtexte'];
        }
        if (isset($_GET['id_article'])) {
            $id_article = $_GET['id_article'];
        }
        if (isset($_GET['idarticle'])) {
            $id_article = $_GET['idarticle'];
        }
        if (isset($_GET['id_collection'])) {
            $id_collection = $_GET['id_collection'];
        }
        if (isset($_GET['id_sous_collection'])) {
            $id_sous_collection = $_GET['id_sous_collection'];
        }
        //dd($id_rubrique);
        if (isset($id_rubrique) && $id_rubrique != null) {
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $id_dossier = $rubrique->getDossier()->getId();
            $dossier = $dossierRepository->find($id_dossier);
            $session->set('rubrique', $rubrique);
            $rubrique = $session->get('rubrique');
        }

        if (isset($id_article)) {
            $article = $articleRepository->find($id_article);
            $session->set('article', $article);
            $article = $session->get('article');
        }
        
        if (isset($id_texte)) {
            $selection = $session->get('selection', []);
            $selection[$ressource->getId()] = $id_texte;
            $session->set('selection', $selection);
            //$texte = $texteRepository->find($id_texte);
        }
        if (isset($id_collection)) {
            $collection = $collectioncndRepository->find($id_collection);
            $sous_collection = $souscollectioncndRepository->find($id_sous_collection);
            $session->set('collection', $collection);
            $selection = $session->get('selection', []);
            $selection[$ressource->getId()] = $id_sous_collection;
            $session->set('selection', $selection);
            $collection = $session->get('collection');
            $session->set('souscollection', $sous_collection);
            $sous_collection = $session->get('souscollection');
        }     
       
            if (isset($_GET['string'])) {
                $search_expression = $_GET['string'];
            }else {
                $search_expression = " ";
            }
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
        
            }else {
                $page = 1;
            }
            if (isset($search_expression)) {
                $query = $ressourceRepository->findWithSearchExpression($search_expression);
            }else{
                $query = $ressourceRepository->findWithSearch($search);
            }
            $ressources = $paginator->paginate(
                $query,
                $request->query->getInt('page', $page),
                12
            );
            $selection = $session->get('selection');
            $selectionComplete = [];
            if(isset($id_texte)) {
                foreach ($selection as $id => $idtexte) {
                    $selectionComplete[] = [
                        'ressource' => $ressourceRepository->find($id),
                        'texte' => $texteRepository->find($idtexte)
                    ];
                }
            }
            if(isset($id_sous_collection)) {
                if(empty($selectionComplete)) {
                foreach ($selection as $id => $idsouscollection) {
                    $selectionComplete[] = [
                        'ressource' => $ressourceRepository->find($id),
                        'souscollection' => $souscollectioncndRepository->find($idsouscollection)
                    ];
                }
                }
                //dd($selectionComplete);
            }
            
            if (isset($id_rubrique) && $id_rubrique != null) {
                return $this->render('admin/ressource/index.html.twig', [
                    'rubrique' => $rubrique,
                    'dossier' => $dossier,
                    'ressources' => $ressources,
                    'selection' => $selection,
                    'selectioncomplete' => $selectionComplete,
                    'form' => $form->createView()
                ]);
            }
            if (isset($id_article) && $id_article != null ) {
                return $this->render('admin/ressource/index.html.twig', [
                    'article' => $article,
                    'ressources' => $ressources,
                    'selection' => $selection,
                    'selectioncomplete' => $selectionComplete,
                    'form' => $form->createView()
                ]);
            }
            if (isset($id_collection) && $id_collection != null ) {
                return $this->render('admin/ressource/index.html.twig', [
                    'collection' => $collection,
                    'souscollection' => $sous_collection,
                    'ressources' => $ressources,
                    'selection' => $selection,
                    'selectioncomplete' => $selectionComplete,
                    'form' => $form->createView()
                ]);
            }
    }
    
    #[Route('/ma-selection/{id}', name: 'app_show_selection')]
    public function showSelection(SessionInterface $session, RessourceRepository $ressourceRepository, TexteRepository $texteRepository, RubriqueRepository $rubriqueRepository, SouscollectioncndRepository $souscollectioncndRepository)
    {
        $rubrique = $session->get('rubrique');
        $article = $session->get('article');
        $collection = $session->get('collection');
        $selection = $session->get('selection');
        $sous_collection = $session->get('souscollection');
        

        $selectionComplete = [];
        if(isset($rubrique) || isset($article)) {
            if(empty($selectionComplete)){
                foreach ($selection as $id => $idtexte) {
                    $selectionComplete[] = [
                        'ressource' => $ressourceRepository->find($id),
                        'texte' => $texteRepository->find($idtexte)
                    ];
                }
            }
        }
        if(isset($collection)) {
            foreach ($selection as $id => $idsouscollection) {
                $selectionComplete[] = [
                    'ressource' => $ressourceRepository->find($id),
                    'souscollection' => $souscollectioncndRepository->find($idsouscollection)
                ];
            }
        }
        
        if (isset($rubrique)) {
            $rubrique = $rubriqueRepository->find($rubrique->getId());
            $dossier = $rubrique->getDossier();
            return $this->render('admin/ressource/selection.html.twig', [
                'rubrique' => $rubrique,
                'dossier' => $dossier,
                'selectioncomplete' => $selectionComplete

            ]);
        }

        if (isset($article)) {
            return $this->render('admin/ressource/selection.html.twig', [
                'article' => $article,
                'selectioncomplete' => $selectionComplete
            ]);
        }

        if (isset($collection)) {
            return $this->render('admin/ressource/selection.html.twig', [
                'collection' => $collection,
                'souscollection' => $sous_collection,
                'selectioncomplete' => $selectionComplete
            ]);
        }
    }
    

    #[Route('/ma-selection-add/{id}', name: 'app_add_selection')]
    public function Addelection(SessionInterface $session, RessourceRepository $ressourceRepository, TexteRepository $texteRepository, RubriqueRepository $rubriqueRepository, DossierRepository $dossierRepository, SouscollectioncndRepository $souscollectioncndRepository, ArticleRepository $articleRepository)
    {
        $rubrique = $session->get('rubrique');
        $article = $session->get('article');
        $selection = $session->get('selection');
        $id_texte = $session->get('id_texte');
        $collection = $session->get('collection');
        $sous_collection = $session->get('souscollection');
        if (isset($collection)){
            $id_collection = $collection->getId();
        }
        //dd($article);
        //dd($id_texte);
        //$session->clear();
        
        if (isset($id_texte) && $id_texte != null) {
            $selections = $session->get('selection');
            //dd($id_texte);
            foreach ($selections as $k => $v) {
                $ressource = $ressourceRepository->find($k);
                $texte = $texteRepository->find($id_texte);
                $ressource->addTexte($texte);
                $ressourceRepository->add($ressource);
            }
            //$session->remove('selection');
            $session->clear();
        }

        if (isset($rubrique)) {
            $id_rubrique = $rubriqueRepository->find($rubrique->getId());
            $rubrique = $rubriqueRepository->find($id_rubrique);
            $id_dossier = $rubrique->getDossier()->getId();
            $dossier = $dossierRepository->find($id_dossier);
            return $this->render('admin/rubrique/show.html.twig', [
                'rubrique' => $rubrique,
                'dossier' => $dossier
            ]);
        }
        
        if (isset($article)) {
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        if (isset($id_collection)) {
            $selections = $session->get('selection');
           
            foreach ($selections as $k => $v) {
                $ressource = $ressourceRepository->find($k);
                $sous_collection = $souscollectioncndRepository->find($v);
                $ressource->addSouscollectioncnd($sous_collection);
                $ressourceRepository->add($ressource);
            }
            //$session->remove('selection');
            $session->clear();
            
            return $this->render('admin/souscollectioncnd/show.html.twig', [
                'souscollectioncnd' => $sous_collection,
                'collection' => $collection
            ]);
        }
    }
    
    #[Route('/removeRessourceFromTexte/{id}', name: 'app_remove_ressource_texte')]
    public function removeRessourceRubrique(Ressource $ressource, DossierRepository $dossierRepository,  ArticleRepository $articleRepository, TexteRepository $texteRepository, SousrubriqueRepository $sousrubriqueRepository, RubriqueRepository $rubriqueRepository): Response
    {
            $em = $this->entityManager;

            if (isset($_GET['id_texte'])) {
                $id_texte = $_GET['id_texte'];
                $texte = $texteRepository->find($id_texte);
               
                $texte->removeRessource($ressource);
                $ressource->removeTexte($texte);
                $em->flush();

            if (isset($_GET['id_sous_rubrique'])) {
                $id_sous_rubrique = $_GET['id_sous_rubrique'];
                $sous_rubrique = $sousrubriqueRepository->find($id_sous_rubrique);
                $rubrique = $sous_rubrique->getRubrique();
                
                $id_dossier = $sous_rubrique->getRubrique()->getDossier()->getId();
                $dossier = $dossierRepository->find($id_dossier);
                return $this->render('admin/rubrique/show.html.twig', [
                    'sousrubrique' => $sous_rubrique,
                    'dossier' => $dossier,
                    'rubrique' => $rubrique
                ]);
            }
            if (isset($_GET['id_rubrique'])) {
                $id_rubrique = $_GET['id_rubrique'];
                $rubrique = $rubriqueRepository->find($id_rubrique);
                $id_dossier = $rubrique->getDossier()->getId();
                $dossier = $dossierRepository->find($id_dossier);
                return $this->render('admin/rubrique/show.html.twig', [
                    'rubrique' => $rubrique,
                    'dossier' => $dossier
                ]);
            }
            if (isset($_GET['id_article'])) {
                $id_article = $_GET['id_article'];
                $article = $articleRepository->find($id_article);
                return $this->render('admin/article/show.html.twig', [
                    'article' => $article
                ]);
            }
        }        
    }

    #[Route('/addRessourceToSouscollection/{id}', name: 'app_add_ressource_souscollection')]
    public function addRessourceSouscollection(Ressource $ressource, CollectioncndRepository $collectioncndRepository,  RessourceRepository $ressourceRepository, SouscollectioncndRepository $souscollectioncndRepository): Response
    {
            if (isset($_GET['id_sous_collection'])) {
                $id_sous_collection = $_GET['id_sous_collection'];
                $id_collection = $_GET['id_collection'];
                $collection = $collectioncndRepository->find($id_collection);
                $sous_collection = $souscollectioncndRepository->find($id_sous_collection);
                $ressource->addSouscollectioncnd($sous_collection);
                $ressourceRepository->add($ressource);
                
                return $this->render('admin/souscollectioncnd/show.html.twig', [
                    'souscollectioncnd' => $sous_collection,
                    'collection' => $collection
                ]);
                    
        }        
    }

    #[Route('/removeRessourceFromSouscollection/{id}', name: 'app_remove_ressource_souscollection')]
    public function removeRessourceSouscollection(Ressource $ressource, CollectioncndRepository $collectioncndRepository, SouscollectioncndRepository $souscollectioncndRepository): Response
    {
            $em = $this->entityManager;

            if (isset($_GET['id_sous_collection'])) {
                $id_sous_collection = $_GET['id_sous_collection'];
                $id_collection = $_GET['id_collection'];
                $collection = $collectioncndRepository->find($id_collection);
                $sous_collection = $souscollectioncndRepository->find($id_sous_collection);
                $sous_collection->removeRessource($ressource);
                $ressource->removeSouscollectioncnd($sous_collection);
                $em->flush();

                return $this->render('admin/souscollectioncnd/show.html.twig', [
                    'souscollectioncnd' => $sous_collection,
                    'collection' => $collection
                ]);
        }        
    }

    #[Route('/removeRessourceFromSelection/{id}', name: 'app_remove_ressource_selection')]
    public function removeressourcefromselection (SessionInterface $session, Ressource $ressource, RessourceRepository $ressourceRepository, TexteRepository $texteRepository, SouscollectioncndRepository $souscollectioncndRepository, RubriqueRepository $rubriqueRepository): Response
    { 
        $selection = $session->get('selection');
        $rubrique = $session->get('rubrique');
        $article = $session->get('article');
        $collection = $session->get('collection');
        $sous_collection = $session->get('souscollection');
        
        $id_ressource = $ressource->getId();
        unset($selection[$id_ressource]);
        $session->set('selection', $selection);

        $selectionComplete = [];
        if(isset($rubrique) || isset($article)) {
            foreach ($selection as $id => $idtexte) {
                $selectionComplete[] = [
                    'ressource' => $ressourceRepository->find($id),
                    'texte' => $texteRepository->find($idtexte)
                ];
            }
        }
        if(isset($collection)) {
            foreach ($selection as $id => $idsouscollection) {
                $selectionComplete[] = [
                    'ressource' => $ressourceRepository->find($id),
                    'souscollection' => $souscollectioncndRepository->find($idsouscollection)
                ];
            }
        }
        
        if (isset($rubrique)) {
            $rubrique = $rubriqueRepository->find($rubrique->getId());
            $dossier = $rubrique->getDossier();
            return $this->render('admin/ressource/selection.html.twig', [
                'rubrique' => $rubrique,
                'dossier' => $dossier,
                'selectioncomplete' => $selectionComplete

            ]);
        }

        if (isset($article)) {
            return $this->render('admin/ressource/selection.html.twig', [
                'article' => $article,
                'selectioncomplete' => $selectionComplete
            ]);
        }

        if (isset($collection)) {
            return $this->render('admin/ressource/selection.html.twig', [
                'collection' => $collection,
                'souscollection' => $sous_collection,
                'selectioncomplete' => $selectionComplete
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }
    
    public function getBlockPrefix()
    {
       return '';
    }
}