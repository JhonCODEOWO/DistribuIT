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


    /** @param array<int, float> $items donde int es el id y float la cantidad de ese producto*/
    public function addProductsToSale(array $items, int $id){
        $sale = $this->findOne($id);
        $attachment = array(); //Arreglo clave valor id => ["subtotal", "quantity"]

        //TODO: Validar cada producto y tipado de elementos en $items
        foreach ($items as $id => $quantity) {
            //Obtener producto
            $product = Product::findOrFail($id);
            //Verificar si ya existe en la venta actual
            $existsInSale = $sale->products->contains($product->id);

            //Si el producto no existe en la venta se prepara para añadir, en caso contrario se coloca la nueva info.
            (!$existsInSale)? 
                $attachment[$id] = ["quantity" => $quantity, "subtotal" => $product->price * $quantity]
                : $sale->products()->updateExistingPivot($product->id, ["quantity" => $quantity, "subtotal" => $product->price * $quantity]);
        };

        //Añadir los productos a la venta
        $sale->products()->attach($attachment);

        return $sale;
    }

    public function updateProductInSale(Sale $sale, int $idProduct, array $data){

    }
}