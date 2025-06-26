<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Services\SaleService;
use Livewire\Component;
use Livewire\WithPagination;

class SaleList extends Component
{
    use WithPagination;
    protected function saleService(): SaleService{
        return app(SaleService::class);
    }
    public function render()
    {
        $sales = app(SaleService::class)->findAll();
        return view('livewire.sales.sale-list', ["sales" => $sales]);
    }
}
