<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/{_locale}/article", locale="en\fr", defaults={"_locale"="fr"})
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param ArticleRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $articleList = $paginator->paginate(
            $repository->getAllArticles(),
            $request->query->getInt('page', 1),
            10
        );
        dump($articleList);
        $params = $this->getTwigParameterWithAside(
            ['articleList'=> $articleList, 'pageTitle' => '']
        );
        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-author/{id}", name="article-by-author")
     * @param Author $author
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param ArticleRepository $repository
     * @return Response
     */
    public function showByAuthor(Author $author, Request $request, PaginatorInterface $paginator, ArticleRepository $repository){

        $articleList = $paginator->paginate(
            $repository->getAllByAuthor($author),
            $request->query->getInt('page', 1),
            10
        );

        $params = $this->getTwigParameterWithAside(
            ['articleList' => $articleList, 'pageTitle' => "de l'auteur : " . $author->getFullName()]
        );

        return $this->render('article/index.html.twig', $params
        );
    }

    private function getTwigParameterWithAside($data){
        $asideData = [
            'authorList' => $this->getDoctrine()
                ->getRepository(Author::class)
            ->findAll()
        ];

        return array_merge($data, $asideData);
    }

    /**
     * @Route("/new", name="article-new")
     * @IsGranted("ROLE_AUTHOR")
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function addOrEdit(Request $request, $id=null)
    {
        $article = new Article();
        $article->setAuthor($this->getUser());
        //Equivalent de @IsGranted dans les annotations
        //$this->denyAccessUnlessGranted('ROLE_AUTHOR');

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash("sucess", "Votre article a été ajouté");

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            //'article' => $article,
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article-details", requirements={"id"="\d+"})
     * @param Article $article
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */

    public function details(Article $article, Request $request){
        $comment = new Comment();
        $comment->setArticle($article)
            ->setCreatedAt(new \DateTime());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été enrrgistré');

            return $this->redirectToRoute('article-details', ['id' => $article->getId()]);
        }
        return $this->render('article/details.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

}
