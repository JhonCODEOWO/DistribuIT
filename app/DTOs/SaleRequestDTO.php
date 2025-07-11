<?php

namespace App\DTOs;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'SaleRequestDTO',
    schema: 'sale_request',
    description: 'DTO used to make requests related with a sale, use it in create and update request'
)]
/**
 * Class to manage/transform/assign data from a Request related to a sale.
 */
class SaleRequestDTO
{
    #[OAT\Property(type: 'string', description: 'Longitude for the sale', nullable: true, example: 19.041951517694)]
    public ?string $lng;

    #[OAT\Property(type: 'string', description: 'Latitude for the sale', nullable: true, example: -98.199081402743)]
    public ?string $lat;

    #[OAT\Property(type: 'string', description: 'Street to deploy the sale', nullable: true, example: 'Zaragosa')]
    public ?string $street;

    #[OAT\Property(type: 'string', description: 'City to deploy the sale', nullable: true, example: 'Puebla')]
    public ?string $city;

    #[OAT\Property(type: 'string', description: 'Internal number of the house', nullable: true, example: 'S/N')]
    public ?string $internal_number;

    #[OAT\Property(type: 'string', description: 'Street to deploy the sale', nullable: true, example: 'S/N')]
    public ?string $external_number;

    #[OAT\Property(type: 'string', description: 'Specific details to locate the place of deploy', nullable: true, example: 'Besides the blue house')]
    public ?string $references;

    #[OAT\Property(type: 'string', description: 'Due date to end the sale in format YYYY-MM-DDTHH:MM', nullable: true, example: '2025-08-25T14:00')]
    public ?string $due_date;

    #[OAT\Property(type: 'array', description: '', nullable: true, items: new OAT\Items(
        type: 'object',
        required: ['product_id', 'quantity'],
        properties: [
            new OAT\Property(property: 'product_id', type: 'integer', example: 3, description: 'ID of a product'),
            new OAT\Property(property: 'quantity', type: 'integer', example: 5, description: 'Quantity of items to buy')
        ]
    ))]
    private array $products = [];

    /**
     * The ID of the authenticated user. 
     * This is injected by the backend and should not be included in the request body.
     */
    public int | null $idUser;
    /**
     * Create a new class instance.
     * @param array $data The data array including all key's necessary to each property otherwise they'll be ignored.
     * @param ?int $idUser The id of the user to append this sale, send it only if is necessary
     */
    public function __construct(array $data, ?int $idUser = null)
    {
        $this->lng = $data['lng'] ?? null;
        $this->lat = $data['lat'] ?? null;
        $this->street = $data['street'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->references = $data['references'] ?? null;
        $this->internal_number = $data['internal_number'] ?? null;
        $this->external_number = $data['external_number'] ?? null;
        $this->due_date = $data['due_date'] ?? null;
        $this->products = $data['products'] ?? [];
        $this->idUser = $idUser;
    }

    /**
     * Retrieves an array with all data related to a sale table in DB.
     * @return array A array with key/value elements where key is the property of a column in DB, excluding null values from it.
     */
    public function getSaleData(): array
    {
        $saleData = array();
        $saleData['lng'] = $this->lng;
        $saleData['lat'] = $this->lat;
        $saleData['street'] = $this->street;
        $saleData['city'] = $this->city;
        $saleData['references'] = $this->references;
        $saleData['internal_number'] = $this->internal_number;
        $saleData['external_number'] = $this->external_number;
        $saleData['due_date'] = $this->due_date;
        $saleData['user_id'] = $this->idUser;

        return array_filter($saleData, fn($item) => !is_null($item));
    }

    /**
     * Retrieves the array of products.
     * @return array The property products of the class.
     */
    public function getProducts()
    {
        return $this->products;
    }
}
