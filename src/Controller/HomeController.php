<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/m2i")
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="homepage")
     * @return Response
     */
    public function index()
    {
        return new Response("Hello symfony");
    }

    /**
     * @Route("/hello/{name}/{age}", requirements={"age":"[1-9][0-9]?|11[0-9]|120|100"})
     * @return Response
     */
    public function hello($age, $name)
    {
        return new Response("<h1>Hello again $name, vous avez $age</h1>");
    }

    /**
     * @Route("/good-afternoon/{name}")
     */

    public function goodAfternoon($name){
        return $this->render("home/afternoon.html.twig",
            [
                "name" => $name,
                "fruitList" => ["Pommes", "Orange", "Grenades"]
            ]);

    }
}