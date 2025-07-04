<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class MapViewer extends Component
{
    /** @var float $lat Latitud a inicializar*/
    public $lat = 0;

    /** @var float $lng Longitud a inicializar*/
    public $lng = 0;

    public $zoom = 0;
    public function render()
    {
        return view('livewire.shared.map-viewer');
    }
}
