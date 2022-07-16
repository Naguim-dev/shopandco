<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Services\displayAllCategories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(displayAllCategories $displayAllCategories): Response
    {
        $categories = $displayAllCategories->allCategories();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
        ]);
    }
}
