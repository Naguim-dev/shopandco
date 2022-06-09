<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();

        $user->setEmail('true@test.com')
             ->setLastName('lastname')
             ->setFirstName('firstname')
             ->setPassword('password')
             ->setZipcode('zipcode')
             ->setAddress('address')
             ->setCity('city')
             ->setRoles(['ROLE_TEST']);

        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getLastName() === 'lastname');
        $this->assertTrue($user->getFirstName() === 'firstname');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getZipcode() === 'zipcode');
        $this->assertTrue($user->getAddress() === 'address');
        $this->assertTrue($user->getCity() === 'city');
        $this->assertTrue($user->getUserIdentifier() === 'true@test.com');
        $this->assertTrue($user->getRoles() === ['ROLE_TEST', 'ROLE_USER']);
    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setEmail('true@test.com')
             ->setLastName('lastname')
             ->setFirstName('firstname')
             ->setPassword('password')
             ->setZipcode('zipcode')
             ->setAddress('address')
             ->setCity('city');

        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getLastName() === 'false');
        $this->assertFalse($user->getFirstName() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
        $this->assertFalse($user->getZipcode() === 'false');
        $this->assertFalse($user->getAddress() === 'false');
        $this->assertFalse($user->getCity() === 'false');
        $this->assertFalse($user->getUserIdentifier() === 'false@test.com');        
    }  
    
    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail() === '');
        $this->assertEmpty($user->getFirstName() === '');
        $this->assertEmpty($user->getLastName() === '');
        $this->assertEmpty($user->getPassword() === '');
        $this->assertEmpty($user->getZipcode() === '');
        $this->assertEmpty($user->getAddress() === '');
        $this->assertEmpty($user->getCity() === '');
        $this->assertEmpty($user->getUserIdentifier());
        $this->assertEmpty($user->getId() === '');
        $this->assertEmpty($user->getRoles() === '');
    } 
   
    public function testAddGetRemoveOrder()
    {
        $user = new User();
        $order = new Order();

        $this->assertEmpty($user->getOrders());

        $user->addOrder($order);
        $this->assertContains($order, $user->getOrders());

        $user->removeOrder($order);
        $this->assertEmpty($user->getOrders());
    } 
        
 }
