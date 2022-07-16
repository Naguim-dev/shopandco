<?php

namespace App\Services;

use App\Repository\CategoryRepository;

class displayAllCategories
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function allCategories()
    {
        return $this->categoryRepository->findAllCategoriesOrderByName();
    }
}
