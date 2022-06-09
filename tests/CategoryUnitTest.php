<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $category = new Category();

        $category->setName('name')
                 ->setParent($category)
                 ->addCategory($category);

        $this->assertTrue($category->getName() === 'name');
        $this->assertTrue($category->getParent() === $category);
        $this->assertContains($category, $category->getCategories());
    }

    public function testIsFalse()
    {
        $category = new Category();

        $category->setName('name')
                 ->setParent($category)
                 ->addCategory($category);

        $this->assertFalse($category->getName() === 'false');
        $this->assertFalse($category->getParent() === new Category());
        $this->assertNotContains(new category(), $category->getCategories());
    }

    public function testIsEmpty()
    {
        $category = new Category();

        $this->assertEmpty($category->getName() === '');
        $this->assertEmpty($category->getParent() === '');
        $this->assertEmpty($category->getCategories() === '');
        $this->assertEmpty($category->getId() === '');
    }

    public function testAddGetRemoveCategory()
    {
        $category = new Category();

        $this->assertEmpty($category->getCategories());

        $category->addCategory($category);
        $this->assertContains($category, $category->getCategories());

        $category->removeCategory($category);
        $this->assertEmpty($category->getCategories());
    }

    public function testAddGetRemoveProduct()
    {
        $category = new Category();
        $product = new Product();

        $this->assertEmpty($category->getProducts());

        $category->addProduct($product);
        $this->assertContains($product, $category->getProducts());

        $category->removeProduct($product);
        $this->assertEmpty($category->getProducts());
    }
}
