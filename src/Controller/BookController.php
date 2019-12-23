<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/book/new", name="book_create")
     * @Route("/book/edit/{id}", name="book-edit")
     * @param Request $request
     * @return Response
     */
    public function createOrEditBook(Request $request, $id=null)
    {
        if ($id == null) {
            $book = new Book();
            //$book->setPublisher(new Publisher());
        } else {
            $book = $this->getDoctrine()
                ->getRepository(Book::class)
                ->find($id);
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute("book-list");
        }

        return $this->render("book/new.html.twig", [
            "bookForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/book/delete/{id}", name="book-delete")
     * @param $id
     * @return RedirectResponse
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
