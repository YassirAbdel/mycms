<?php

namespace App\Controller;

use App\Classe\ContactNotification;
use App\Entity\Dossier;
use App\Entity\Article;
use App\Entity\Collectioncnd;
use App\Entity\Contact;
use App\Entity\Rubrique;
use App\Entity\Souscollectioncnd;
use App\Entity\Sousrubrique;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CollectioncndRepository;
use App\Repository\DossierRepository;
use App\Repository\RessourceRepository;
use App\Repository\RubriqueRepository;
use App\Repository\SouscollectioncndRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class FrontController extends AbstractController
{
    private $dossierRepository;
    private $collectionRepository;
    private $articleRepository;
    private $ressourceRepository;
    private $paginator;
    private $souscollectionRepository;
    private $notification;
    
    public function __construct(DossierRepository $dossierRepository, CollectioncndRepository $collectionRepository, ArticleRepository $articleRepository, PaginatorInterface $paginatorInterface, RessourceRepository $ressourceRepository, SouscollectioncndRepository $souscollectioncndRepository, ContactNotification $contactNotification)
    {
        $this->dossierRepository = $dossierRepository;
        $this->collectionRepository = $collectionRepository;
        $this->articleRepository = $articleRepository;
        $this->ressourceRepository = $ressourceRepository;
        $this->collectionRepository = $collectionRepository;
        $this->paginator = $paginatorInterface;
        $this->souscollectionRepository = $souscollectioncndRepository;
        $this->notification = $contactNotification;
    }
    
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $dossiersFront = $this->dossierRepository->findFolderFront();
        $dossiers = $this->dossierRepository->findDossiersPublished();
        $collectionsFront = $this->collectionRepository->findFolderFront();
        $collections = $this->collectionRepository->findCollections();
        $archive = $this->collectionRepository->find(7);
        $articlesFront = $this->articleRepository->findFolderFront();
        $articles = $this->articleRepository->findArticlesPublished();
        $query = $this->ressourceRepository->findAllFront();
        // Activation mode aléatoire !navigation ne fonctionne plus
        //shuffle($query);
        $lastRessources = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),/* page number */
            8
        );
        
        $lastRessources->setCustomParameters([
            'align' => 'left', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            //'span_class' => 'whatever',
            //'rounded' => true,
        ]);
        $total = $lastRessources->getTotalItemCount();
        //$lastRessources->setItemNumberPerPage(12);
        //$lastRessources->setItemNumberPerPage(1);
       
        
        // On fusionne les 3 tableaux
        $front_all = array_merge($dossiersFront, $collectionsFront, $articlesFront);
        $edito_all = array_merge($dossiers, $articles);

        // Randomiser l'ordre des éléments du tableau $front_all
        shuffle($front_all);
        
        // formulaire contact
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre message a bien été envoyé, merci !');
            $this->notification->notify($contact);
            return $this->render('front/index.html.twig', [
                'front' => $front_all,
                'lastRessources' => $lastRessources,
                'collections' => $collections,
                'produits' => $edito_all,
                'total' => $total,
                'archive' => $archive,
                'form' => $form->createView(),
                '_fragment' => 'ancre'
            ]);
        
        }

        return $this->render('front/index.html.twig', [
            'front' => $front_all,
            'lastRessources' => $lastRessources,
            'collections' => $collections,
            'produits' => $edito_all,
            'total' => $total,
            'archive' => $archive,
            'form' => $form->createView()
        ]);
    }

    #[Route('dossier/{slug}-{id}', name: 'front_dossier_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showDossier(Dossier $dossier, RubriqueRepository $rubriqueRepository)
    {
        $slug = $dossier->getSlug();
        $id = $dossier->getId();
        $rubriques = $rubriqueRepository->findByidDossier($id);
        $menu = 1;
        $sousmenu = 1;
        
        return $this->render('front/dossier.html.twig', [
            'dossier' => $dossier,
            'slug' => $slug,
            'id' => $id,
            'rubriques' => $rubriques,
            'menu' => $menu,
            'sousmenu' => $sousmenu
        ]);
    }

    #[Route('article/{slug}-{id}', name: 'front_article_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showArticle(Article $article)
    {
        $slug = $article->getSlug();
        $id = $article->getId();
        return $this->render('front/article.html.twig', [
            'article' => $article,
            'slug' => $slug,
            'id' => $id
        ]);
    }

    #[Route('rubrique/{slug}-{id}', name: 'front_rubrique_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showRubrique(Rubrique $rubrique): Response
    {
        $dossier = $rubrique->getDossier();
        $rubriques = $dossier->getRubriques();
        $id = $dossier->getId();
        $menu = $rubrique->getId();
        $sousmenu = 1;
        
        return $this->render('front/rubrique.html.twig', [
            'dossier' => $dossier,
            'id' => $id,
            'rubriques' => $rubriques,
            'rubrique' => $rubrique,
            'menu' => $menu,
            'sousmenu' => $sousmenu
        ]);
    }

    #[Route('rubriquepdf/{slug}-{id}', name: 'front_rubriquepdf_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function expotPdfRubrique(Rubrique $rubrique, ParameterBagInterface $params)
    {
        $dossier = $rubrique->getDossier();
        $rubriques = $dossier->getRubriques();
        $id = $dossier->getId();
        $menu = $rubrique->getId();
        $sousmenu = 1;
        
        $data = [
            'dossier_titre' => $dossier->getTitre(),
            'rubrique_titre' => $rubrique->getTitre(),
            'rubrique_textes' => $rubrique->getTextes()
        ];
        
        // Store PDF Binary Data
        // $output = $dompdf->output();
       // In this case, we want to write the file in the public directory
       //$publicDirectory = $this->get('kernel')->getProjectDir() . '/public';
       // e.g /var/www/project/public/mypdf.pdf
       //$pdfFilepath =  $publicDirectory . '/mypdf.pdf';
       // Write file to the desired path
       //file_put_contents($pdfFilepath, $output);

        $html = $this->renderView('front/pdf_generator/rubrique.html.twig', $data);
        //dd($html);
        $exportPdf = new Dompdf();
        $options = $exportPdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set("isPhpEnabled", true);
        $options->set('isJavascriptEnabled', true);
        $options->set('tempDir', '/Users/abdelmontet/Documents/http/mycms/public/tmp');
        $options->setDefaultFont('Arial');
        
        //$options->setlogOutputFile('CND');
        $exportPdf->setOptions($options);
        $exportPdf->setPaper('A4', 'portrait');
        
        $exportPdf->loadHtml($html);
        $exportPdf->render();
        // Ajout pagination
        //$logoFile = $params->get('kernel.project_dir') . '/public/logo_cnd.png';
        $canvas = $exportPdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        $text = date("Y-m-d H:i") . " - " . "Page $pageNumber / $pageCount";
        //$logo = "CN D";
        
        $font = $fontMetrics->getFont('Arial');
        $pageWidth = $canvas->get_width();
        $pageHeight = $canvas->get_height();
        $size = 8;
        //$sizeLogo = 30;
        $width = $fontMetrics->getTextWidth($text, $font, $size);
        $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text, $font, $size);
        //$canvas->text($pageWidth - $width - 480, 5, $logo, $font, $size_logo);
        //$canvas->image($logoFile,$pageWidth - $width - 480, 5);
});
        
        return new Response (
            $exportPdf->stream($dossier->getTitre() . "__" . $rubrique->getTitre(), ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-type' => 'application/pdf']
        );
        
    }

    #[Route('sous-rubrique/{slug}-{id}', name: 'front_sousrubrique_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showSousrubrique(Sousrubrique $sousrubrique): Response
    {   
        $rubrique = $sousrubrique->getRubrique();
        $dossier = $rubrique->getDossier();
        $rubriques = $dossier->getRubriques();
        $id = $dossier->getId();
        $menu = $rubrique->getId();
        $sousmenu = $sousrubrique->getId();
        
        return $this->render('front/sousrubrique.html.twig', [
            'dossier' => $dossier,
            'id' => $id,
            'rubriques' => $rubriques,
            'sousrubrique' => $sousrubrique,
            'menu' => $menu,
            'sousmenu' => $sousmenu
        ]);
    }

    #[Route('collection/{slug}-{id}', name: 'front_collection_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showcollection(Collectioncnd $collection): Response
    {
        return $this->render('front/collection.html.twig', [
            'collection' => $collection
        ]);
    }

    #[Route('sous-collection/{slug}-{id}', name: 'front_souscollection_show', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'], methods: ['GET'])]
    public function showsouscollection(Souscollectioncnd $souscollection): Response
    {
        return $this->render('front/souscollection.html.twig', [
            'souscollection' => $souscollection
        ]);
    }

    #[Route('toutes-les-collections', name: 'front_collections_show')]
    public function showCollections(Request $request): Response
    {
        $query = $this->collectionRepository->findAllCollections();
        $collections = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),/* page number */
            8
        );

        return $this->render('front/toutes-les-collections.twig.html', [
            'collections' => $collections
        ]);
    }

    #[Route('tous-les-dossiers', name: 'front_dossiers_show')]
    public function showDossiers(Request $request): Response
    {   
        $dossiers = $this->dossierRepository->findDossiersPublished();
        $articles = $this->articleRepository->findArticlesPublished();
        $produits = array_merge($dossiers, $articles);
        
        return $this->render('front/tous-les-dossiers.html.twig', [
            'produits' => $produits
        ]);
    }
}
