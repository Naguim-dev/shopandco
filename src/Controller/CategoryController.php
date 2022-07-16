<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Services\displayAllCategories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{slug}", name="list")
     */

    public function list(
        Category $category,
        displayAllCategories $displayAllCategories
    ): Response {
        $categories = $displayAllCategories->allCategories();
        $products = $category->getProducts();
        return $this->render(
            'category/list.html.twig',
            compact('categories', 'products', 'category')
        );
    }
}
