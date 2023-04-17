<?php

namespace App\DataFixtures;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FruitFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($x = 0; $x <= 50; $x++) {
            $fruitEntity = new Fruit();
            $nutrition = new Nutrition();
            $nutrition->setCalories(rand(1, 20))
            ->setFat(rand(1, 20))
            ->setSugar(rand(1, 20))
            ->setCarbohydrates(rand(1, 20))
            ->setProtein(rand(1, 20));
            $fruitEntity->setName("Fruit_name_{$x}")
                        ->setFamily("Fruit_fam_{$x}")
                        ->setFruitOrder("Fruit_order_{$x}")
                        ->setGenus("Fruit_genus_{$x}")
                        ->setNutritions($nutrition);
            $manager->persist($fruitEntity);
            $manager->flush();
        }
    }
}
