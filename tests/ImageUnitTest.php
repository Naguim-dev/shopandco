<?php

namespace App\Tests;

use App\Entity\Image;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ImageUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $image = new Image();
        $product = new Product();

        $image->setName('name')
              ->setProduct($product);

        $this->assertTrue($image->getName() === 'name');
        $this->assertTrue($image->getProduct() === $product);
    }

    public function testIsFalse()
    {

        $image = new Image();
        $product = new Product();

        $image->setName('name')
              ->setProduct($product);

        $this->assertFalse($image->getName() === 'false');
        $this->assertFalse($image->getProduct() === new Product());
    }

    public function testIsEmpty()
    {
        $image = new Image();

        $this->assertEmpty($image->getName());
        $this->assertEmpty($image->getproduct());
        $this->assertEmpty($image->getId());
    }
}
