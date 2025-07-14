<?php

namespace App\DTOs;

use App\Models\Product;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'ProductDTO',
    schema: 'product_response',
    description: 'Response of a product in each request related to it',
    type: 'object'
)]
class ProductDTO
{
    #[OAT\Property(title: 'id', description: 'The ID of the product')]
    public int $id;
    #[OAT\Property(title: 'name', description: 'The name of product', example: 'T SHIRT')]
    public string $name;
    #[OAT\Property(title: 'slug', description: 'Slug of product for SEO apps', example: 't_shirt')]
    public string $slug;
    #[OAT\Property(title: 'description', description: 'Description of the product', example: 'A simple T-Shirt')]
    public string $description;
    #[OAT\Property(title: 'price', description: 'Price for unity', example: 99.99)]
    public float $price;
    #[OAT\Property(title: 'stock', description: 'Stock available of product', example: 10)]
    public float $stock;
    #[OAT\Property(title: 'image_url', description: 'Url of the main image of the product', example: 'http://storage/asda.jpg')]
    public string $image_url;
    #[OAT\Property(title: 'created_at', description: 'Date of creation', example: '2025-07-02 18:38:46')]
    public string $created_at;
    #[OAT\Property(title: 'quantityInSale', description: 'Quantity of this product in a sale', nullable: true)]
    public float | null $quantityInSale;
    #[OAT\Property(title: 'subtotal', description: 'Subtotal of this product in a sale', nullable: true)]
    public float | null $subtotal;
    public array $images = [];
    /**
     * Create a new class instance.
     */
    public function __construct(Product $product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->image_url = $product->urlImageResource;
        $this->created_at = $product->created_at;
        $this->quantityInSale = $product->pivot->quantity ?? null;
        $this->subtotal = $product->pivot->subtotal ?? null;
        $this->images = array_map(fn($image) => $image->url_resource,$product->images->all());
    }
}
