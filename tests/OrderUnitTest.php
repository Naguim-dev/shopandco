<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Coupon;
use PHPUnit\Framework\TestCase;

class OrderUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $order = new Order();
        $datetime = new DateTime();
        $user = new User();
        $coupon = new Coupon();
        $orderDetail = new OrderDetail();

        $order->setReference('reference')                       
              ->setCreated_at($datetime)
              ->setUser($user)
              ->setCoupon($coupon)
              ->addOrderDetail($orderDetail);

        $this->assertTrue($order->getReference() === 'reference');
        $this->assertTrue($order->getCreated_at() === $datetime);
        $this->assertTrue($order->getUser() === $user);
        $this->assertTrue($order->getCoupon() === $coupon);
        $this->assertContains($orderDetail, $order->getOrderDetails());
    }

    public function testIsFalse()
    {
        $order = new Order();
        $datetime = new DateTime();
        $user = new User();
        $coupon = new Coupon();
        $orderDetail = new OrderDetail();

        $order->setReference('reference')                       
              ->setCreated_at($datetime)
              ->setUser($user)
              ->setCoupon($coupon)
              ->addOrderDetail($orderDetail);

        $this->assertFalse($order->getReference() === 'false');
        $this->assertFalse($order->getCreated_at() === new DateTime());
        $this->assertFalse($order->getUser() === new User());
        $this->assertFalse($order->getCoupon() === new Coupon());
        $this->assertNotContains(new OrderDetail(), $order->getOrderDetails());
    }

    public function testIsEmpty()
    {
        $order = new Order();

        $this->assertEmpty($order->getReference());
        $this->assertEmpty($order->getCreated_at());
        $this->assertEmpty($order->getUser());
        $this->assertEmpty($order->getCoupon());
        $this->assertEmpty($order->getOrderDetails());
        $this->assertEmpty($order->getId());
    }

    public function testAddGetRemoveOrderDetail()
    {
        $order = new Order();
        $orderDetail = new OrderDetail();

        $this->assertEmpty($order->getOrderDetails());

        $order->addOrderDetail($orderDetail);
        $this->assertContains($orderDetail, $order->getOrderDetails());

        $order->removeOrderDetail($orderDetail);
        $this->assertEmpty($order->getOrderDetails());
    }
}
