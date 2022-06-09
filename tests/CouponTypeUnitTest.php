<?php

namespace App\Tests;

use App\Entity\CouponType;
use App\Entity\Coupon;
use PHPUnit\Framework\TestCase;

class CouponTypeUnitTest extends TestCase
{
    public function testIsTrue()
    {

        $coupon = new Coupon();
        $couponType = new CouponType();

        $couponType->setName('name')
                   ->addCoupon($coupon);

        $this->assertTrue($couponType->getName() === 'name');
        $this->assertContains($coupon, $couponType->getCoupons());
    }

    public function testIsFalse()
    {

        $coupon = new Coupon();
        $couponType = new CouponType();

        $couponType->setName('name')
                   ->addCoupon($coupon);

        $this->assertFalse($couponType->getName() === 'false');
        $this->assertNotContains(new Coupon(), $couponType->getCoupons());
    }

    public function testIsEmpty()
    {
        $couponType = new CouponType();

        $this->assertEmpty($couponType->getName());
        $this->assertEmpty($couponType->getCoupons());
        $this->assertEmpty($couponType->getId());
    }


    public function testAddGetRemoveCoupon()
    {
        $couponType = new CouponType();
        $coupon = new Coupon();

        $this->assertEmpty($couponType->getCoupons());

        $couponType->addCoupon($coupon);
        $this->assertContains($coupon, $couponType->getCoupons());

        $couponType->removeCoupon($coupon);
        $this->assertEmpty($couponType->getCoupons());
    }
}
