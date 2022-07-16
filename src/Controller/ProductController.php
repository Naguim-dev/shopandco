<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", name="products_")
 */

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="list")
     */
    public function list(
        Category $category,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        $slug
    ): Response {
        $categories = $categoryRepository->findAll();
        $slugId = $category->getId($slug);
        $products = $productRepository->findAllProductsByCategoryParent(
            $slugId
        );
        $nbProducts = count($products);
        return $this->render(
            'product/list.html.twig',
            compact('categories', 'products', 'slug', 'nbProducts')
        );
    }

    /**
     * @Route("/{slug}", name="details")
     */
    public function details(Product $product): Response
    {
        return $this->render('product/details.html.twig', compact('product'));
    }
}
