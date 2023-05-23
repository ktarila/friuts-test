<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Controller\Api;

use App\Repository\FruitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/fruit')]
class FruitApiController extends AbstractController
{
    public function __construct(
        private FruitRepository $fruitRepository,
    ) {
    }

    #[Route('/', name: 'app_fruit')]
    public function index(): Response
    {
        $fruits = $this->fruitRepository->findAll();

        return $this->json($fruits);
    }

    #[Route('/favourites', name: 'app_favourite_fruit')]
    public function favourites(): Response
    {
        $fruits = $this->fruitRepository->findFavouriteFruits();

        return $this->json($fruits);
    }
}
