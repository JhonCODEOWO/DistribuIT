<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Services\SaleService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SaleList extends Component
{
    use WithPagination;
    #[Url()]
    public $searchQuery;
    protected function saleService(): SaleService{
        return app(SaleService::class);
    }

    #[On('search-product')]
    public function search($search){
        $this->searchQuery = $search;
    }
    public function render()
    {
        $sales = app(SaleService::class)->findAll(null, $this->searchQuery);
        return view('livewire.sales.sale-list', ["sales" => $sales]);
    }
}
