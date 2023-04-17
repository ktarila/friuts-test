<?php

namespace App\Controller\Api;

use App\Entity\Fruit;
use App\Service\FavouriteFruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favourite-fruit')]
class FavouriteFruitApiController extends AbstractController
{
    public function __construct(
        private FavouriteFruitService $favouriteFruitService,
    ) {
    }
    #[Route('/add/{id}', name: 'app_add_favourite_fruit', methods: ['POST'])]
    public function add(Fruit $fruit): Response
    {
        $favouriteFruit = $this->favouriteFruitService->addFavouriteFruit($fruit);
        $fruit->setFavouriteFruit($favouriteFruit);

        // return the fruit which will also include favorite
        return $this->json($fruit);
    }

    #[Route('/remove/{id}', name: 'app_remove_favourite_fruit', methods: ['POST'])]
    public function remove(Fruit $fruit): Response
    {
        $favouriteFruit = $this->favouriteFruitService->removeFavouriteFruit($fruit);
        $fruit->setFavouriteFruit($favouriteFruit);

        // return the fruit which will also include favorite
        return $this->json($fruit);
    }
}
