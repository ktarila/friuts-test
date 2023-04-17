<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Service;

use App\Entity\FavouriteFruit;
use App\Entity\Fruit;
use App\Repository\FavouriteFruitRepository;
use App\Repository\FruitRepository;

class FavouriteFruitService
{
    public function __construct(
        private FavouriteFruitRepository $favouriteFruitRepository,
        private FruitRepository $fruitRepository,
    ) {
    }

    public function addFavouriteFruit(Fruit $fruit): ?FavouriteFruit
    {
        // Already added to favourite fruit
        if (null !== $fruit->getFavouriteFruit()) {
            return $fruit->getFavouriteFruit();
        }
        $numFavourite = $this->favouriteFruitRepository->countFavoriteFruits();

        // more than 10 favourites replace oldest
        if ($numFavourite > 9) {
            $this->removeOldestFavouriteFruit();
        }

        $favouriteFruit = new FavouriteFruit();
        $favouriteFruit->setFruit($fruit);
        $this->favouriteFruitRepository->save($favouriteFruit, true);

        return $favouriteFruit;
    }

    public function removeFavouriteFruit(Fruit $fruit): ?FavouriteFruit
    {
        $fruit->setFavouriteFruit(null);

        $this->fruitRepository->save($fruit, true);

        return null;
    }

    public function removeOldestFavouriteFruit()
    {
        $oldest = $this->favouriteFruitRepository->findOldest();
        if (null !== $oldest) {
            $this->favouriteFruitRepository->remove($oldest, true);
        }
    }
}
