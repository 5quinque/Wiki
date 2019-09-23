<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function getOrder()
    {
        return 1;
    }
    public const MYSQL_CATEGORY_REFERENCE = 'mysql-category';
    public const LINUX_CATEGORY_REFERENCE = 'linux-category';
    public const PROGRAMMING_CATEGORY_REFERENCE = 'programming-category';
    public const OTHER_CATEGORY_REFERENCE = 'other-category';

    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('MySQL');
        $category->setVisible(true);

        $manager->persist($category);

        $this->addReference(self::MYSQL_CATEGORY_REFERENCE, $category);

        $category = new Category();
        $category->setName('Linux');
        $category->setVisible(true);

        $manager->persist($category);

        $this->addReference(self::LINUX_CATEGORY_REFERENCE, $category);

        $category = new Category();
        $category->setName('Programming');
        $category->setVisible(true);

        $manager->persist($category);

        $this->addReference(self::PROGRAMMING_CATEGORY_REFERENCE, $category);

        $category = new Category();
        $category->setName('Other');
        $category->setVisible(true);

        $manager->persist($category);

        $this->addReference(self::OTHER_CATEGORY_REFERENCE, $category);

        $manager->flush();
    }
}
