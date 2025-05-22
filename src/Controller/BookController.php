<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use App\Form\BookTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('library/book/create', name: 'book_create')]
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $booksData = [
        [
           'title' => 'Harry Potter',
           'isbn' => '978-0-7000-3269-9',
           'author' => 'J.K. Rowling',
           'image' => 'harry.jpg',
        ],
        [
           'title' => 'Python for Dummies',
           'isbn' => '12345-687-809',
           'author' => 'Stef Maruch',
           'image' => 'dum.jpg',
        ],
        [
           'title' => 'The Power of Letting Go',
           'isbn' => '978-1-78678-656-0',
           'author' => 'John Purkiss',
           'image' => 'pow.jpg',
        ],
    ];

        foreach ($booksData as $data) {
            $book = new Book();
            $book->setTitle($data['title']);
            $book->setIsbn($data['isbn']);
            $book->setAuthor($data['author']);
            $book->setImage($data['image']);

            $entityManager->persist($book);
        }

        $entityManager->flush();

        return new Response('Three books added successfully.');
    }

    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    //  the /library view converable
    #[Route('/library', name: 'book_view_all')]
    public function viewAllProduct(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    #[Route('library/book/view/{id}', name: 'book_view_by_id')]
    public function viewBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('book/book.html.twig', [
            'book' => $book,
        ]);
    }


    // edit the book details
    #[Route('library/book/edit/{id}', name: 'book_edit', methods: ['GET', 'POST'])]
    public function editBook(
        Request $request,
        ManagerRegistry $doctrine,
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $form = $this->createForm(BookTypeForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('book_view_all');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    #[Route('library/book/new', name: 'book_new')]
    public function newBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $book = new Book();
        $form = $this->createForm(BookTypeForm::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_view_all');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }


    // delete a book by its id
    #[Route('library/book/delete/{id}', methods: ['POST'], name: 'book_delete_by_id')]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }



}
