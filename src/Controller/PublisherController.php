<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    /**
     * @Route("/publisher-list", name="publisher-list")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Publisher::class);
        $publisherList = $repository->findAll();

        return $this->render('publisher/index.html.twig', [
            'controller_name' => 'PublisherController',
            'publisherList' => $publisherList
        ]);
    }

    /**
     * @Route("/publisher/new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPublisher(Request $request)
    {
        $publisher = new Publisher();
        $form = $this->createForm(PublisherType::class, $publisher);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em =$this->getDoctrine()->getManager();
            $em->persist($publisher);
            $em->flush();

            return  $this->redirectToRoute("publisher-list");
        }

        return $this->render("publisher/new.html.twig", [
            "publisherForm" => $form->createView()
        ]);
    }
    /**
     * @Route("/publisher/delete/{id}", name="publisher-delete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePublisher($id)
    {
        $repository = $this->getDoctrine()->getRepository(Publisher::class);
        $publisher = $repository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        if ($publisher) {
            $entityManager->remove($publisher);

            $entityManager->flush();
        }


        return $this->redirectToRoute("publisher-list");
    }
}
