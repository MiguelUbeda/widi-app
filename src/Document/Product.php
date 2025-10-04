<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'products', repositoryClass: 'App\Repository\ProductRepository')]
class Product
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $asin = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $title = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $brand = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $imageUrl = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $productUrl = null;

    #[MongoDB\Field(type: 'float')]
    private ?float $price = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $currency = null;

    #[MongoDB\Field(type: 'int')]
    private ?int $discount = null;

    #[MongoDB\Field(type: 'collection')]
    private array $features = [];

    #[MongoDB\Field(type: 'int')]
    private ?int $position = null;

    #[MongoDB\Field(type: 'float')]
    private ?float $rating = null;

    #[MongoDB\Field(type: 'float')]
    private ?float $stars = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $ratingLabel = null;

    #[MongoDB\Field(type: 'bool')]
    private bool $freeShipping = false;

    public function getId(): ?string { return $this->id; }
    
    public function getAsin(): ?string { return $this->asin; }
    public function setAsin(string $asin): self { $this->asin = $asin; return $this; }
    
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    
    public function getBrand(): ?string { return $this->brand; }
    public function setBrand(?string $brand): self { $this->brand = $brand; return $this; }
    
    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }
    
    public function getProductUrl(): ?string { return $this->productUrl; }
    public function setProductUrl(string $productUrl): self { $this->productUrl = $productUrl; return $this; }
    
    public function getPrice(): ?float { return $this->price; }
    public function setPrice(?float $price): self { $this->price = $price; return $this; }
    
    public function getCurrency(): ?string { return $this->currency; }
    public function setCurrency(?string $currency): self { $this->currency = $currency; return $this; }
    
    public function getDiscount(): ?int { return $this->discount; }
    public function setDiscount(?int $discount): self { $this->discount = $discount; return $this; }
    
    public function getFeatures(): array { return $this->features; }
    public function setFeatures(array $features): self { $this->features = $features; return $this; }
    
    public function getPosition(): ?int { return $this->position; }
    public function setPosition(int $position): self { $this->position = $position; return $this; }
    
    public function getRating(): ?float { return $this->rating; }
    public function setRating(float $rating): self { $this->rating = $rating; return $this; }
    
    public function getStars(): ?float { return $this->stars; }
    public function setStars(float $stars): self { $this->stars = $stars; return $this; }
    
    public function getRatingLabel(): ?string { return $this->ratingLabel; }
    public function setRatingLabel(string $ratingLabel): self { $this->ratingLabel = $ratingLabel; return $this; }
    
    public function isFreeShipping(): bool { return $this->freeShipping; }
    public function setFreeShipping(bool $freeShipping): self { $this->freeShipping = $freeShipping; return $this; }

    public function generateRandomRating(): void
    {
        $this->rating = round(mt_rand(90, 99) / 10, 1);
        
        if ($this->rating >= 9.7) {
            $this->stars = 5.0;
            $this->ratingLabel = 'Excepcional';
        } elseif ($this->rating >= 9.5) {
            $this->stars = 5.0;
            $this->ratingLabel = 'Excelente';
        } elseif ($this->rating >= 9.3) {
            $this->stars = 4.5;
            $this->ratingLabel = 'Excelente';
        } elseif ($this->rating >= 9.0) {
            $this->stars = 4.2;
            $this->ratingLabel = 'Genial';
        } else {
            $this->stars = 4.0;
            $this->ratingLabel = 'Genial';
        }

        $this->freeShipping = mt_rand(1, 10) <= 8;
    }
}
