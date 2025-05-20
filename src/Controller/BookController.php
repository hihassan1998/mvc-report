<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/book/show', name: 'book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
