<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\OrderDetail;
use App\Entity\Product;
use DateTime;
use PHPUnit\Framework\TestCase;

class ProductUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $product = new Product();
        $category = new Category();
        $datetime = new DateTime();
        $image = new Image();
        $orderDetail = new OrderDetail();

        $product->setName('name')
                ->setDescription('description')  
                ->setPrice(20)
                ->setStock(1)
                ->setCreated_at($datetime)
                ->setCategory($category)
                ->addImage($image)
                ->addOrderDetail($orderDetail);

        $this->assertTrue($product->getName() === 'name');
        $this->assertTrue($product->getDescription() === 'description');
        $this->assertTrue($product->getPrice() === 20);
        $this->assertTrue($product->getStock() === 1);
        $this->assertTrue($product->getCreated_at() === $datetime);
        $this->assertTrue($product->getCategory() === $category);
        $this->assertContains($image, $product->getImages());
        $this->assertContains($orderDetail, $product->getOrderDetails());
    }

    public function testIsFalse()
    {

        $product = new Product();
        $category = new Category();
        $datetime = new DateTime();
        $image = new Image();
        $orderDetail = new OrderDetail();

        $product->setName('name')
                ->setDescription('description')  
                ->setPrice(20)
                ->setStock(1)
                ->setCreated_at($datetime)
                ->setCategory($category)
                ->addImage($image)
                ->addOrderDetail($orderDetail);

        $this->assertFalse($product->getName() === 'false');
        $this->assertFalse($product->getDescription() === 'false');
        $this->assertFalse($product->getPrice() === 21);
        $this->assertFalse($product->getStock() === 2);
        $this->assertFalse($product->getCreated_at() === new Datetime());
        $this->assertFalse($product->getCategory() === new Category());
        $this->assertNotContains(new Image(), $product->getImages());
        $this->assertNotContains(new OrderDetail(), $product->getOrderDetails());
    }

    public function testIsEmpty()
    {
        $product = new Product();

        $this->assertEmpty($product->getName());
        $this->assertEmpty($product->getDescription());
        $this->assertEmpty($product->getPrice());
        $this->assertEmpty($product->getStock());
        $this->assertEmpty($product->getCreated_at());
        $this->assertEmpty($product->getCategory());
        $this->assertEmpty($product->getImages());
        $this->assertEmpty($product->getOrderDetails());
        $this->assertEmpty($product->getId());
    }

    public function testAddGetRemoveImage()
    {
        $image = new Image();
        $product = new Product();

        $this->assertEmpty($product->getImages());

        $product->addImage($image);
        $this->assertContains($image, $product->getImages());

        $product->removeImage($image);
        $this->assertEmpty($product->getImages());
    }

    public function testAddGetRemoveOrderDetail()
    {
        $orderDetail = new OrderDetail();
        $product = new Product();

        $this->assertEmpty($product->getOrderDetails());

        $product->addOrderDetail($orderDetail);
        $this->assertContains($orderDetail, $product->getOrderDetails());

        $product->removeOrderDetail($orderDetail);
        $this->assertEmpty($product->getOrderDetails());
    }
}
