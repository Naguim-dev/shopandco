<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $counter;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        // create categories! Bim!

        $parent = $this->createCategory('Homme', null, $manager);

        $this->createCategory('Chemises', $parent, $manager);
        $this->createCategory('T-shirts', $parent, $manager);

        $parent = $this->createCategory('Femme', null, $manager);

        $this->createCategory('Chaussures', $parent, $manager);
        $this->createCategory('Robes', $parent, $manager);

        $manager->flush();
    }
    public function createCategory(
        string $name,
        Category $parent = null,
        ObjectManager $manager
    ) {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
