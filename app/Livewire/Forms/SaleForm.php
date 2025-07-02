<?php

namespace App\Livewire\Forms;

use App\Models\Sale;
use DateTime;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SaleForm extends Form
{
    private ?int $id = null;
    public float $lng;
    public float $lat;
    public string $street;
    public string $city;
    public string $internal_number = 'S/N';
    public string $external_number = 'S/N';
    public string $references;
    public int $user_id;
    public string $due_date;

    public function rules(){
        $globalRules = [
            "lng" => 'required',
            "lat" => 'required',
            "street" => "required",
            "city" => "required",
            "internal_number" => "required",
            "external_number" => "required",
            "references" => "required",
            "user_id" => "required|exists:users,id",
            "due_date" => "required|date",
        ];

        return $globalRules;
    }

    public function save(): Sale{
        $this->validate();
        // if(isset($this->id)){
        //     //Hacer update
        //     return;
        // }
        //Crear registro
        return $this->create();
    }

    public function create(){
        return Sale::create($this->all());
    }

    public function update(){
        
    }

    public function setSale(Sale $sale){
        $this->id = $sale->id;
        $this->lat = $sale->lat;
        $this->lng = $sale->lng;
    }
}
