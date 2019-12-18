<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login-author", name="security-login")
     * @param Request $request
     * @param AuthenticationUtils $helper
     * @return Response
     */

    public function authorLogin(Request $request, AuthenticationUtils $helper)
    {
        dump($helper->getLastAuthenticationError());

        return $this->render('security/login.html.twig', [
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'formTitle' => 'Identification des auteurs',
            'formAction' => $this->generateUrl('author-login-check')
        ]);

    }

    /**
     * @Route("/login-admin", name="admin-login")
     * @param AuthenticationUtils $helper
     * @return Response
     */

    public function adminLogin(AuthenticationUtils $helper)
    {
        return $this->render('security/login.html.twig', [
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'formTitle' => 'Identification des administateurs',
            'formAction' => $this->generateUrl('admin-login-check')
        ]);

    }

}