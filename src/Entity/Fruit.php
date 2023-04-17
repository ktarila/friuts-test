<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
#[UniqueEntity('name')]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $fruitOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $genus = null;

    #[ORM\OneToOne(fetch: 'EAGER', inversedBy: 'fruit', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nutrition $nutritions = null;

    #[ORM\OneToOne(fetch: 'EAGER', mappedBy: 'fruit', targetEntity: FavouriteFruit::class, orphanRemoval: true)]
    private ?FavouriteFruit $favouriteFruit;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getFruitOrder(): ?string
    {
        return $this->fruitOrder;
    }

    public function setFruitOrder(string $fruitOrder): self
    {
        $this->fruitOrder = $fruitOrder;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getNutritions(): ?Nutrition
    {
        return $this->nutritions;
    }

    public function setNutritions(Nutrition $nutritions): self
    {
        $this->nutritions = $nutritions;

        return $this;
    }

    public function getFavouriteFruit(): ?FavouriteFruit
    {
        return $this->favouriteFruit;
    }

    public function setFavouriteFruit(?FavouriteFruit $favouriteFruit): self
    {
        $this->favouriteFruit = $favouriteFruit;

        return $this;
    }
}
