<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService {
    public function findAll(bool $paginated = false){
        return ($paginated)? $this->transformDataInPaginatorToDto(Product::paginate(env('PAGINATED_ITEMS'))): $this->transformCollectionToDto(Product::all());
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
        return $paginator;
    }

    function transformCollectionToDto(Collection $data): Collection{
        return $data->map(fn($product) => new ProductDTO($product));
    }
}