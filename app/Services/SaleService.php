<?php
namespace  App\Services;
use App\Models\Sale;

class SaleService {
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
}