<?php 

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController {

    /**
    * @Route ("/", name="home")
    * @param PropertyRepository $Repository
    * @var Environment
    */
    public function index (PropertyRepository $Repository): Response {
        $properties = $Repository->findlast();
        return $this->render('pages/home.html.twig', ['properties' => $properties]);
    }

}