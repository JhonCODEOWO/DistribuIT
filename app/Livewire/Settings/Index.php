<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    public $settings = null;
    
    #[Validate('required')]
    #[Validate('min:6')]
    public $APP_NAME;

    #[Validate('nullable')] 
    #[Validate('mimes:ico')] 
    public $APP_ICON;
    public $APP_ICON_PREV = null;

    // public $imageService = null;

    public function mount(){
        $this->settings = Setting::all()->pluck('value', 'key'); //Cargar todos los registros en clave/valor
        $this->APP_NAME = $this->settings['APP_NAME']; 
        $this->APP_ICON_PREV = $this->settings['APP_ICON']; 
    }

    public function save(ImageService $imageService){
        $safe = $this->validate(); //Validate form data
        
        //Set plain values to update
        $updates = [
            "APP_NAME" => $safe['APP_NAME']
        ];

        //Delete previous image
        if($this->APP_ICON_PREV && $this->APP_ICON) $imageService->deleteIfExists('app_resources', $this->APP_ICON_PREV);

        //Upload icon to the app if is present
        if($this->APP_ICON)
            $updates['APP_ICON'] = $imageService->saveOriginalInto($safe['APP_ICON'], 'app_resources');

        //For each element in updates....
        foreach ($updates as $key => $value) {
            $setting = Setting::where('KEY', $key)->update(["value" => $value]); //Find the register with the key and update its value

            //Apply effects to determinated keys....
            switch($key){
                case 'APP_ICON':
                    $this->APP_ICON_PREV = $updates["APP_ICON"];
                    break;
            }
        }

        //Reset values that aren't necessary
        $this->reset("APP_ICON");
        session()->flash('status', 'Datos actualizados correctamente');
    }

    public function render()
    {
        
        return view('livewire.settings.index');
    }
}
