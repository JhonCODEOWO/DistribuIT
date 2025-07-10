<?php

namespace App\DTOs;

use App\Models\Sale;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'SaleDTO',
    schema: 'sale_response',
    description: 'Response of a sale in each request related to it',
    type: 'object'
)]
class SaleDTO
{
    #[OAT\Property(title: 'id', description: 'ID of the sale', example: 1)]
    public int $id;
    #[OAT\Property(title: 'lng', description: 'Longitude of location', example: 75.560052)]
    public string $lng;
    #[OAT\Property(title: 'lat', description: 'Latitude of location', example: -64.462155)]
    public string $lat;
    #[OAT\Property(title: 'city', description: 'City of sale', example: 'New Alfred')]
    public string $city;
    #[OAT\Property(title: 'street', description: 'Street of the sale', example: 'Werner Port')]
    public string $street;
    #[OAT\Property(title: 'internal_number', description: 'Internal number of sale', example:  'S/N')]
    public string $internal_number;
    #[OAT\Property(description: 'External number of sale', example:  'S/N')]
    public string $external_number;
    #[OAT\Property(title: 'references', description: 'References to deploy the sale', example: 'Crossing the main street in the withe house')]
    public string $references;
    #[OAT\Property(title: 'user', description: 'Client that wants the sale', type: 'object', ref: '#/components/schemas/user_response')]
    public UserDTO $user;
    #[OAT\Property(title: 'products', description: 'Products in the sale', type: 'array', items: new OAT\Items(ref: '#/components/schemas/product_response'))]
    public array $products; //Array de ProductDTO
    #[OAT\Property(title: 'created_at', description: 'Date of creation', example: '2025-07-07 20:19:29')]
    public string $created_at;
    #[OAT\Property(title: 'update_at', description: 'Date of last update', example: '2025-07-07 20:19:29')]
    public string $updated_at;

    /**
     * Asignar todos los datos a exponer en el DTO.
     */
    public function __construct(Sale $sale)
    {
        $this->id = $sale->id;
        $this->lng = $sale->lng;
        $this->lat = $sale->lat;
        $this->city = $sale->city;
        $this->street = $sale->street;
        $this->internal_number = $sale->internal_number;
        $this->external_number = $sale->external_number;
        $this->references = $sale->references;
        $this->user = new UserDTO($sale->user);
        $this->products = array_map(fn($product) => new ProductDTO($product), $sale->products->all());
    }
}
