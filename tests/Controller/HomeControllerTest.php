<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /** @test */
    public function fruitsList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    /** @test */
    public function favouriteList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/favourites');

        $this->assertResponseIsSuccessful();
    }
}
