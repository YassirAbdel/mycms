<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Form\ImageType;
use App\Form\ImageType as FormImageType;
use App\Form\UploadType;
use App\Repository\ImageRepository;
use App\Repository\TexteRepository;
use Liip\ImagineBundle\Form\Type\ImageType as TypeImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/image')]
class ImageController extends AbstractController
{
    #[Route('/', name: 'app_image_index')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }

    #[Route('/new', name: 'app_image_new', methods:['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, ImageRepository $imageRepository, TexteRepository $texteRepository)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte = $texteRepository->find(170);
            $image->setTexte($texte);
            $imageRepository->add($image);
            
        }
        return $this->render('admin/image/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/removeImage/{id}', name: 'app_image_remove')]
     public function removeFile($id, ImageRepository $imageRepository, Request $request)
     {
            $image = $imageRepository->find($id);
            $texte = $image->getTexte();
            $rubrique = $texte->getRubrique();
            
            $file_with_path = $this->getParameter ( 'imagestextes_directory' ) . "/" . $image->getImageName();
            unlink($file_with_path);
            $imageRepository->remove($image);
            
            $model = $_GET['model'];
            if ( $model == 0 ) {
                $route = $request->headers->get('referer');
                return $this->redirect($route);
            }
            if ( $model == 2 ) {
                $sous_rubrique = $texte->getSousrubrique();
                $rubrique = $sous_rubrique->getRubrique();
                $dossier = $rubrique->getDossier();
                return $this->render('admin/rubrique/show.html.twig', [
                    'sousrubrique' => $sous_rubrique,
                    'rubrique' => $rubrique,
                    'dossier' => $dossier
                ]);
            }
            if ( $model == 1) {
                $dossier = $rubrique->getDossier();
                return $this->render('admin/rubrique/show.html.twig', [
                    'rubrique' => $rubrique,
                    'dossier' => $dossier
                ]);
            }
     }

     #[Route('/{id}/edit', name: 'app_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageRepository $imageRepository, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->add($image);
            
            return $this->renderForm('admin/image/edit.html.twig', [
                'image' => $image,
                'form' => $form,
            ]);
        
        }

        return $this->renderForm('admin/image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

}
