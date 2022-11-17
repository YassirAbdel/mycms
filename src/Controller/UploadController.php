<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Repository\TexteRepository;
use App\Repository\UploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/upload')]
class UploadController extends AbstractController
{
    #[Route('/', name: 'app_upload_index')]
    public function index(): Response
    {
        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }

    #[Route('/new', name: 'app_upload_new', methods:['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, UploadRepository $uploadRepository, TexteRepository $texteRepository)
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->get('titre')->getData();
            $uploadFile = $form->get('filename')->getData();
            if ($uploadFile) {
                $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();
                try {
                    $uploadFile->move(
                        $this->getParameter('filespdf_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e);
                }
                $texte = $texteRepository->find(170);
                $upload->setTexte($texte);
                $upload->setTitre($titre);
                $upload->setFilename($newFilename);
                $uploadRepository->add($upload);
            }

        }
        return $this->render('admin/upload/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/download/{slug}-{id}', name:'app_upload_download', requirements: ['slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$', 'id' => '\d+'])]
    public function download($id, UploadRepository $uploadRepository) {

        $downloadedFile = $uploadRepository->find($id);
        $slug = $downloadedFile->getSlug();
        $response=new Response();
    
        $response = new Response();
        $file_with_path = $this->getParameter ( 'filespdf_directory' ) . "/" . $downloadedFile->getFilename();
        $response = new BinaryFileResponse ( $file_with_path );
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $downloadedFile->getFilename() ));
        $response->setStatusCode(200);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;
    
     }

     #[Route('/removeFile/{id}', name: 'app_upload_remove')]
     public function removeFile($id, UploadRepository $uploadRepository, Request $request)
     {
            $file = $uploadRepository->find($id);
            $file_with_path = $this->getParameter ( 'filespdf_directory' ) . "/" . $file->getFilename();
            unlink($file_with_path);
            //dd($file_with_path);
            $uploadRepository->remove($file);
            $route = $request->headers->get('referer');
            return $this->redirect($route);
     }
}
