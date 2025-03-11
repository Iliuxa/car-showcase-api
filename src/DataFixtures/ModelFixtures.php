<?php

namespace App\DataFixtures;

use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture
{
    const modelNames = [
        'Внедорожник',
        'Спорткар',
        'Грузовик'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::modelNames as $modelName) {
            $model = (new Model())->setName($modelName);
            $manager->persist($model);
        }

        $manager->flush();
    }
}