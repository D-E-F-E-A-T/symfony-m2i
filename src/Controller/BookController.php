<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book-list", name="book-list")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $bookList = $repository->findAll();

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'bookList' => $bookList
        ]);
    }

    /**
     * @Route("/book/new")
     */
    public function createBook()
    {
        $book = new Book();
        $book->setAuthor("Platon")
            ->setTitle("La République")
            ->setPrice(5);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        return $this->render("book/new.html.twig", [
            "book" => $book
        ]);
    }

    /**
     * @Route("/book/delete/{id}", name="book-delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBook($id)
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        if ($book) {
            $entityManager->remove($book);

            $entityManager->flush();
        }


        return $this->redirectToRoute("book-list");
    }
}
