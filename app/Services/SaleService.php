<?php
namespace  App\Services;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleService {
    public function create(array $data): Sale{
        return Sale::create($data);
    }
    public function findOne(int $id): Sale{
        $sale = Sale::findOrFail($id);
        return $sale;
    }

    public function findAll(?string $searchQuery = null){
        return Sale::paginate(5);
    }

    public function delete(int $id): bool{
        $product = $this->findOne($id);
        return $product->delete();
    }

    public function update(int $id, array $data){
        $sale = $this->findOne($id);
        $sale->update($data);
    }


    /** @param array<int, float> $items*/
    public function addProductsToSale(array $items, int $id){
        $sale = $this->findOne($id);
        $attachment = array();

        //TODO: Validar cada producto y tipado de elementos en $items
        foreach ($items as $id => $quantity) {
            //Obtener producto
            $product = Product::findOrFail($id);
            //Verificar si ya existe en la venta actual
            $existsInSale = $sale->products->contains($product->id);

            (!$existsInSale)? 
                $attachment[$id] = ["quantity" => $quantity, "subtotal" => $product->price * $quantity]
                : $sale->products()->updateExistingPivot($product->id, ["quantity" => $quantity, "subtotal" => $product->price * $quantity]);
        };
        $sale->products()->attach($attachment);

        return $sale;
    }

    public function updateProductInSale(Sale $sale, int $idProduct, array $data){

    }
}