<?php
namespace  App\Services;
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
}