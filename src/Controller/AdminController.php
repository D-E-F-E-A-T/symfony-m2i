<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @param ArticleRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $articleList = $paginator->paginate(
            $repository->getAllArticles(),
            $request->query->getInt('page', 1),
            10
        );
        dump($articleList);

        return $this->render('admin/index.html.twig', [
            'articleList'=> $articleList,
                ]
        );
    }

    /**
     * @Route("/admin/heaven", name="gate-to-heaven")
     */
    public function gateToHeaven()
    {
        $this->render('admin/gate-to-heaven.html.twig');

    }

    /**
     * @Route("/admin/delete-article/{id}",
     *      name="article-delete",
     *     requirements={"id" ="\d+"})
     *
     * @IsGranted("ROLE_ADMIN")
     * @param Article $article
     * @return RedirectResponse
     */

    public function deleteArticle(Article $article){
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('admin_index');
    }

}
