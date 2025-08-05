<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService {
    /**
     * Find all products and retrieve a paginated instance or array with all data
     * @param $paginated Flag to decide if the data returned is a paginated instance or not
     */
    public function findAll(bool $paginated = false,string $query = ""){
        return ($paginated)? $this->transformDataInPaginatorToDto(Product::where('name', 'like', '%'.$query.'%')->paginate(env('PAGINATED_ELEMENTS'))): $this->transformCollectionToDto(Product::all());
    }
    public function findOne(string $id): Product | null{
        $product = null;
        if(ctype_digit($id)) {
            $product = Product::findOrFail($id);
        } else {
            $product = Product::where('slug', $id)->first();
        }

        return $product;
    }

    /**
     * Returns an instance of paginator with new data items that has DTO applied
     */
    function transformDataInPaginatorToDto(LengthAwarePaginator $paginator): LengthAwarePaginator{
        $paginator->setCollection($this->transformCollectionToDto($paginator->getCollection()));
        $paginator->withQueryString();
        return $paginator;
    }

    /**
     * Transform a collection data to ProductDTO collection
     * @param \Illuminate\Support\Collection $data Collection data.
     * @return \Illuminate\Support\Collection New collection with each item is ProductDTO
     */
    function transformCollectionToDto(Collection $data): Collection{
        return $data->map(fn($product) => new ProductDTO($product));
    }
}