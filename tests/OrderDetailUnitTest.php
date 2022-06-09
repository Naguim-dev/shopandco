<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class OrderDetailUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $orderDetail = new OrderDetail();
        $order = new Order();
        $product = new Product();

        $orderDetail->setQuantity(1)
                    ->setPrice(10)           
                    ->setOrders($order)
                    ->setProduct($product);

        $this->assertTrue($orderDetail->getQuantity() === 1);
        $this->assertTrue($orderDetail->getPrice() === 10);
        $this->assertTrue($orderDetail->getOrders() === $order);
        $this->assertTrue($orderDetail->getProduct() === $product);
    }

    public function testIsFalse()
    {

        $orderDetail = new OrderDetail();
        $order = new Order();
        $product = new Product();

        $orderDetail->setQuantity(1)
                    ->setPrice(10)           
                    ->setOrders($order)
                    ->setProduct($product);

        $this->assertFalse($orderDetail->getQuantity() === 2);
        $this->assertFalse($orderDetail->getPrice() === 11);
        $this->assertFalse($orderDetail->getOrders() === new Order());
        $this->assertFalse($orderDetail->getProduct() === new Product());
    }

    public function testIsEmpty()
    {
        $orderDetail = new OrderDetail();

        $this->assertEmpty($orderDetail->getQuantity());
        $this->assertEmpty($orderDetail->getPrice());
        $this->assertEmpty($orderDetail->getOrders());
        $this->assertEmpty($orderDetail->getProduct());
    }
}
