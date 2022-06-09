<?php

namespace App\Tests;

use DateTime;
use App\Entity\CouponType;
use App\Entity\Order;
use App\Entity\Coupon;
use PHPUnit\Framework\TestCase;

class CouponUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $coupon = new Coupon();
        $datetime = new DateTime();
        $couponType = new CouponType();
        $order = new Order();

        $coupon->setCode('code')
               ->setDescription('description')  
               ->setDiscount(20)
               ->setMaxUsage(1)
               ->setCreated_at($datetime)
               ->setValidity($datetime)
               ->setIsValid(true)
               ->setCouponType($couponType)
               ->addOrder($order);

        $this->assertTrue($coupon->getCode() === 'code');
        $this->assertTrue($coupon->getDescription() === 'description');
        $this->assertTrue($coupon->getDiscount() === 20);
        $this->assertTrue($coupon->getMaxUsage() === 1);
        $this->assertTrue($coupon->getCreated_at() === $datetime);
        $this->assertTrue($coupon->getValidity() === $datetime);
        $this->assertTrue($coupon->getIsValid() === true);
        $this->assertTrue($coupon->getCouponType() === $couponType);
        $this->assertContains($order, $coupon->getOrders());
    }

    public function testIsFalse()
    {

        $coupon = new Coupon();
        $datetime = new DateTime();
        $couponType = new CouponType();
        $order = new Order();

        $coupon->setCode('code')
               ->setDescription('description')  
               ->setDiscount(20)
               ->setMaxUsage(1)
               ->setCreated_at($datetime)
               ->setValidity($datetime)
               ->setIsValid(true)
               ->setCouponType($couponType)
               ->addOrder($order);

        $this->assertFalse($coupon->getCode() === 'false');
        $this->assertFalse($coupon->getDescription() === 'false');
        $this->assertFalse($coupon->getDiscount() === 21);
        $this->assertFalse($coupon->getMaxUsage() === 2);
        $this->assertFalse($coupon->getCreated_at() === new datetime());
        $this->assertFalse($coupon->getValidity() === new datetime());
        $this->assertFalse($coupon->getIsValid() === false);
        $this->assertFalse($coupon->getCouponType() === new CouponType());
        $this->assertNotContains(new Order(), $coupon->getOrders());
    }

    public function testIsEmpty()
    {
        $coupon = new Coupon();

        $this->assertEmpty($coupon->getCode());
        $this->assertEmpty($coupon->getDescription());
        $this->assertEmpty($coupon->getDiscount());
        $this->assertEmpty($coupon->getMaxUsage());
        $this->assertEmpty($coupon->getCreated_at());
        $this->assertEmpty($coupon->getValidity());
        $this->assertEmpty($coupon->getIsValid());
        $this->assertEmpty($coupon->getCouponType());
        $this->assertEmpty($coupon->getOrders());
        $this->assertEmpty($coupon->getId());
    }



    public function testAddGetRemoveOrder()
    {
        $order = new Order();
        $coupon = new Coupon();

        $this->assertEmpty($coupon->getOrders());

        $coupon->addOrder($order);
        $this->assertContains($order, $coupon->getOrders());

        $coupon->removeOrder($order);
        $this->assertEmpty($coupon->getOrders());
    }
}
