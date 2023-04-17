<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Entity;

use App\Repository\FavouriteFruitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: FavouriteFruitRepository::class)]
class FavouriteFruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'favouriteFruit')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Fruit $fruit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruit(): ?Fruit
    {
        return $this->fruit;
    }

    public function setFruit(?Fruit $fruit): self
    {
        $this->fruit = $fruit;

        return $this;
    }
}
