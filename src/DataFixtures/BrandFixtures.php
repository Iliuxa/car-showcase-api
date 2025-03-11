<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    const brandNames = [
        'Мерседес',
        'БМВ',
        'Москвич'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::brandNames as $brandName) {
            $brand = (new Brand())->setName($brandName);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}