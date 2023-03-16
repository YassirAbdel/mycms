<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\ArticleUpdateType;
use App\Repository\ArticleRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, SessionInterface $session): Response
    {       
            //$session->clear();
            return $this->render('admin/article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setType(2);
            $articleRepository->add($article);
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleUpdateType::class, $article);
        $form->handleRequest($request);
        $date = new DateTime('now');

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setupdatedAt($date);
            $articleRepository->add($article);
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
