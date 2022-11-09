<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    // On Initialise la variable $entityManager et $userRepository
    private $entityManager;
    private $userRepository;
    

    // On Ajoute la fonction _construct
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        // On enrigistre l'instance $entityManager dans la variable privée $entityManager
        $this->entityManager = $entityManager;
        // On enrigistre l'instance $userRepository dans la variable $userRepository
        $this->userRepository = $userRepository;
        
    }

    #[Route('/admin/nouveau-compte', name: 'app_register_new')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        // Instancier la classe User() : on ouvre l'objet utilisateur
        $user = new User();
        
        // Instancier objet formulaire (RegisterType) avec la methode avec 2 param (classform et datas) = createForm(ClassForm::class, datas=User())
        $form = $this->createForm(RegisterType::class, $user);
        // on demande au formulaire d'analyser l'objet requete (Request) pr voir si on a un Post
        $form->handleRequest($request);
        // On vérrifie que le formulaire a été soumis et est-ce que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On injecte les données dans l'objet $user (User())
            $user = $form->getData();
            // On encode le password
            $password = $encoder->hashPassword($user, $user->getPassword());
            // On initialise la proprité password
            $user->setPassword($password);
            // On fige les données du formulaire
            $this->entityManager->persist($user);
            // On enrigistre les données dans la table User
            $this->entityManager->flush();
            $users = $this->userRepository->findAll();
            return $this->render('admin/register/index.html.twig', [
                'users' => $users
            ]);
        }
        // Passer la variable $form : createForm à la template index.html.twig et ajouter la création de vue createView()
        return $this->render('admin/register/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('admin/show-users', name: 'app_register_index')]
    public function ShowUsers(): Response
    {
        $users = $this->userRepository->findAll();
        
        return $this->render('admin/register/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('admin/user/{id}/edit', name: 'app_register_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $encoder): Response
    {
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On injecte les données dans l'objet $user (User())
            $user = $form->getData();
            // On encode le password
            $password = $encoder->hashPassword($user, $user->getPassword());
            // On initialise la proprité password
            $user->setPassword($password);
            // On fige les données du formulaire
            $this->entityManager->persist($user);
            // On enrigistre les données dans la table User
            $this->entityManager->flush(); 
            return $this->redirectToRoute('app_register_index');
        }

        return $this->renderForm('admin/register/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('admin/user/{id}', name: 'app_register_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->userRepository->remove($user);
        }

        return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
    }

}
