<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BooksFormType;
use App\Repository\BooksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BooksController extends AbstractController
{
    private $em;
    private $BooksRepository;
    public function __construct(EntityManagerInterface $em, BooksRepository $BooksRepository) 
    {
        $this->em = $em;
        $this->BooksRepository = $BooksRepository;
    }

    #[Route('/books', name: 'books')]
    public function index(): Response
    {
        $books = $this->BooksRepository->findAll();

        return $this->render('books/index.html.twig', [
            'books' => $books
        ]);
    }
    #[Route('/home', name: 'home')]
    public function home(): Response
    {
       

        $books = $this->BooksRepository->findAll();

        return $this->render('books/index.html.twig', [
            'books' => $books
        ]);
    }
 
    #[Route('/books/create', name: 'create_book')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null ,'buraya erişim yetkiniz yok');

        $books = new Books();
        $form = $this->createForm(BooksFormType::class, $books);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid()){
            $newBook=$form->getData();
           
            $imagePath=$form->get('imagePath')->getData();
            if($imagePath){
                $newFileName=uniqid().'.'. $imagePath->guessExtension();
                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads',
                        $newFileName
                    );
                }catch(FileException $e){
                    return new Response($e->getMessage());

                }
                $newBook->setImagePath('/uploads/'.$newFileName);
            }
            $this->em->persist($newBook);
            $this->em->flush();

            return $this->redirectToRoute('books');
        }


        return $this->render('books/create.html.twig',[
            'form'=>$form->createView()
        ]);

       
        
    }
    #[Route('/books/edit/{id}', name: 'edit_books')]
    public function edit($id, Request $request): Response 
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null ,'buraya erişim yetkiniz yok');
        $this->checkLoggedInUser($id);
        $book = $this->BooksRepository->find($id);

        $form = $this->createForm(BooksFormType::class, $book);

        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($book->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $book->getImagePath()
                        )) {
                            $this->GetParameter('kernel.project_dir') . $book->getImagePath();
                    }
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $book->setImagePath('/uploads/' . $newFileName);
                    $this->em->flush();

                    return $this->redirectToRoute('books');
                }
            } else {
                $book->setTitle($form->get('title')->getData());
                $book->setReleaseYear($form->get('releaseYear')->getData());
                $book->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('books');
            }
        }

        return $this->render('books/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView()
        ]);
    }

    #[Route('/books/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_book')]
    public function delete($id): Response
    {
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN',NULL,'BURAYA ERİŞİM YETKİNİZ YOK');
        $this->checkLoggedInUser($id);
        $book = $this->BooksRepository->find($id);
        $this->em->remove($book);
        $this->em->flush();

        return $this->redirectToRoute('books');
    }
    #[Route('/books/read/{id}', name: 'read_book')]
    public function read($id, Request $request): Response
    {       
         $book = $this->BooksRepository->find($id);

        
        if ($book) {
            $users= $this->getUser();
            $users->addBook($book);

            $book = $this->BooksRepository->find($id);
            $this->em->persist($users);
            $this->em->flush();
    

            
            return $this->redirectToRoute('library');
        }

        return $this->redirectToRoute('books');
    }
    #[Route('/books/remove/{id}', name: 'remove_book')]
    public function remove($id, Request $request): Response
    {       
         $book = $this->BooksRepository->find($id);

        
        if ($book) {
            $users= $this->getUser();
            $users->removeBook($book);

            $book = $this->BooksRepository->find($id);
            $this->em->persist($users);
            $this->em->flush();
    

            
            return $this->redirectToRoute('library');
        }

        return $this->redirectToRoute('books');
    }
  
    #[Route('/books/willRead/{id}', name: 'willRead_book')]
    public function willRead($id, Request $request): Response
    {       
         $book = $this->BooksRepository->find($id);

        
        if ($book) {
            $users = $this->getUser();
            $users->addBook($book);

            $book = $this->BooksRepository->find($id);
            $this->em->persist($users);
            $this->em->flush();
    

            
            return $this->redirectToRoute('toBeRead');
        }

        return $this->redirectToRoute('books');
    }
    

    #[Route('/books/{id}', methods: ['GET'], name: 'show_book')]
    public function show($id): Response
    {
        $book = $this->BooksRepository->find($id);
        
        return $this->render('books/show.html.twig', [
            'book' => $book
        ]);
    }
    
    
    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
       
        return $this->render('books/profil.html.twig', [
            
        ]);
    }
    #[Route('/library', name: 'library')]
    public function library(): Response
    {
       
        return $this->render('books/library.html.twig', [
            
        ]);
    }
    #[Route('/toBeRead', name: 'toBeRead')]
    public function toBeRead(): Response
    {
       
        return $this->render('books/toBeRead.html.twig', [
            
        ]);
    }
   
    
    private function checkLoggedInUser($bookId) {
        if($this->getUser() == null || $this->getUser()->getId() !== $bookId) {
            return $this->redirectToRoute('books');
        }
    }
   
}

