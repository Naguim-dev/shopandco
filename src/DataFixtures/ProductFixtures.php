<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private $counter;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for ($prod = 1; $prod <= 20; $prod++) {
            $product = new Product();
            $product->setName($faker->text(10));
            $product->setDescription($faker->text());
            $product->setSlug(
                $this->slugger->slug($product->getName())->lower()
            );
            $product->setPrice($faker->numberBetween(20, 300));
            $product->setStock($faker->numberBetween(0, 15));

            //Searching categories Reference
            $category = $this->getReference('cat-' . rand(1, 6));
            $product->setCategory($category);

            $this->setReference('prod-' . $prod, $product);

            $manager->persist($product);
        }
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
