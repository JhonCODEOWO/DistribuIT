<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TableProducts extends Component
{
    use WithPagination;

    #[Url()]
    public $searchQuery = '';
    public $reset = false;

    #[On('search-product')]
    public function search($query){
        $this->searchQuery = $query;
        return ($this->searchQuery === '')?Product::paginate(5) :Product::where('name', 'like', '%'.$this->searchQuery.'%')->paginate(5);
    }

    #[On('reset-page')]
    public function initialPage(){
        $this->resetPage();
    }

    public function delete(Product $product){
        $product->delete();
    }

    public function render()
    {
        return view('livewire.products.table-products', ["products" => $this->search($this->searchQuery)]);
    }
}
