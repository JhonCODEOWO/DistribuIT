<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class Title extends Component
{
    public $title = '';
    public function render()
    {
        return <<<'HTML'
            <div>
                <h1 class=" text-4xl font-bold">{{ $title }}</h1>
            </div>
        HTML;
    }
}
