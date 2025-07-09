<?php
namespace  App\Services;

use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SaleService {
    public function create(array $data): Sale{
        return Sale::create($data);
    }
    public function findOne(int $id): Sale{
        $sale = Sale::findOrFail($id);
        return $sale;
    }

    public function findAll(?string $searchQuery = null){
        return empty($searchQuery)? Sale::paginate(5): Sale::whereDate('created_at', $searchQuery)->paginate(5);
    }

    /**
     * Delete a sale from DB or just change the state
     * @param int $id The id of the sale to delete
     * @param array {soft?: bool} $options
     */
    public function delete(int $id, array $options = []): bool{
        $mode = $options['soft'] ?? false;
        $product = $this->findOne($id);

        switch ($mode) {
            case false:
                return $product->delete();
                break;
            case true:
                //TODO: Change state of sale to canceled
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    public function update(int $id, array $data, array $items = []){
        $sale = $this->findOne($id);
        DB::beginTransaction();
        try {
            $sale->update($data); //Actualizamos datos de la venta
            if(!empty($items)) $this->addProductsToSale($this->transformToItems($items), $id);
            DB::commit();

            return $sale->load('products');
        } catch (Exception $ex) {
            DB::rollBack();
            abort(500, $ex->getMessage());
        }
    }

    /**
     * Create a sale and add to it the items given
     * @param array $saleData Data about sale to create
     * @param array items Array of objects with properties product_id & quantity
     * @example $items [{product_id = 1, quantity = 2}, {product_id = 3, quantity = 1}]
     * 
     */
    public function createAndAppendProducts(array $saleData, array $items){
        DB::beginTransaction();
        try {
            $items = collect($items)->mapWithKeys(fn($item) => [(int) $item['product_id'] => $item['quantity']])->toArray(); //Convertir json a key value
            $sale = $this->create($saleData);
            $saleWithProducts = $this->addProductsToSale($items, $sale->id);
            DB::commit();
            return $saleWithProducts;
        } catch (Exception $ex) {
            DB::rollBack();
            abort(500, $ex->getMessage());
        }
    }


    /** 
     * Add products to a sale, if some of them exists in it just update the quantity and subtotal
     * @param array<int, float> $items donde int es el id y float la cantidad de ese producto
     * @param int $id Id of sale to append new items
     * */
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

        return $sale->load('products');
    }

    public function updateProductInSale(Sale $sale, int $idProduct, array $data){

    }

    /**
     * Transform a json [{"product_id", "quantity"}] to a key, value array.
     * @param array $items Json to be transformed
     * @return array<int, float> Formatted array to use in service.
     */
    private function transformToItems(array $items): array{
        return collect($items)->mapWithKeys(fn($item) => [(int) $item['product_id'] => $item['quantity']])->toArray();
    }
}