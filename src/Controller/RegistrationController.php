<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{  
    private $em;
    private $UserRepository;
    public function __construct(EntityManagerInterface $em, UserRepository $UserRepository) 
    {
        $this->em = $em;
        $this->UserRepository = $UserRepository;
    }
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('books');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
        #[Route('/user/{id} ', name: 'user_edit')]
        public function edit($id, Request $request): Response
        {
            $user = $this->getUser();
            $form = $this->createForm(RegistrationFormType::class, $user);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $user= $this->UserRepository->find($id);
                $this->em->flush();
    
                return $this->redirectToRoute('books');
            }
    
            return $this->render('books/profil.html.twig', [
                'form' => $form->createView(),
            ]);
        }
}
