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

    #[Route('/book/create', name: 'book_create')]
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle('Book Title ' . rand(1, 100));
        $book->setIsbn('978-3-16-' . rand(1000000, 9999999));
        $book->setAuthor('Author Name ' . rand(1, 10));
        $book->setImage('book' . rand(1, 5) . '.jpg');

        // tell Doctrine you want to (eventually) save the book
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id ' . $book->getId());
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
    // #[Route('/book/update/{id}/{value}', name: 'book_update')]
    // public function updateBook(
    //     ManagerRegistry $doctrine,
    //     int $id,
    //     int $value
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $book = $entityManager->getRepository(Book::class)->find($id);

    //     if (!$book) {
    //         throw $this->createNotFoundException(
    //             'No book found for id ' . $id
    //         );
    //     }

    //     $book->setValue($value);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('product_show_all');
    // }
    // #[Route('/book/update/{id}/{title}', name: 'book_update')]
    // public function updateBookTitle(
    //     ManagerRegistry $doctrine,
    //     int $id,
    //     string $title
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $book = $entityManager->getRepository(Book::class)->find($id);

    //     if (!$book) {
    //         throw $this->createNotFoundException(
    //             'No book found for id ' . $id
    //         );
    //     }

    //     $book->setTitle($title);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('book_show_all');
    // }


    //  the /library view converable
    #[Route('/book/view', name: 'book_view_all')]
    public function viewAllProduct(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    #[Route('/book/view/{id}', name: 'book_view_by_id')]
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
    #[Route('/book/edit/{id}', name: 'book_edit')]
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
            $entityManager->flush(); // Book already tracked, no need for persist()

            return $this->redirectToRoute('book_view_all');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    #[Route('/book/new', name: 'book_new')]
    public function newBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $book = new Book(); // new empty book entity
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
    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
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
