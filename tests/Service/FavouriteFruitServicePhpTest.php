<?php

namespace App\Tests\Service;

use App\Repository\FavouriteFruitRepository;
use App\Repository\FruitRepository;
use App\Service\FavouriteFruitService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FavouriteFruitServicePhpTest extends KernelTestCase
{
    /** @test */
    public function notMoreThanTenFavourites(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        $fruitService = static::getContainer()->get(FavouriteFruitService::class);
        $fruitRepo = static::getContainer()->get(FruitRepository::class);
        $favFruitRepo = static::getContainer()->get(FavouriteFruitRepository::class);

        $fruits = $fruitRepo->findAll();
        foreach ($fruits as $fruit) {
            $fruitService->addFavouriteFruit($fruit);
            $numFavs = $favFruitRepo->countFavoriteFruits();
            $this->assertLessThan(11, $numFavs);
        }
    }
}
