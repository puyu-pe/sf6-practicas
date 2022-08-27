<?php

namespace App\Form\Model\Product;

class ProductDto
{
    private ?string $description = null;
    private ?string $brand = null;
    private ?string $category = null;
    private ?float $price = null;
    private ?string $imageBase64 = null;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return ProductDto
     */
    public function setDescription(?string $description): ProductDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return ProductDto
     */
    public function setBrand(?string $brand): ProductDto
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return ProductDto
     */
    public function setCategory(?string $category): ProductDto
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return ProductDto
     */
    public function setPrice(?float $price): ProductDto
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageBase64(): ?string
    {
        return $this->imageBase64;
    }

    /**
     * @param string|null $imageBase64
     * @return ProductDto
     */
    public function setImageBase64(?string $imageBase64): ProductDto
    {
        $this->imageBase64 = $imageBase64;
        return $this;
    }
}