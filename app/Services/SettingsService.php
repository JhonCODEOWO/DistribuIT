<?php

namespace App\Services;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingsService {
    /**
     * Retrieve an array with all existing settings
     */
    public function retrieveSettings(){
        try {
            $settings = Setting::all()->pluck('value', 'key')->toArray();

            foreach ($settings as $key => $value) {
                if($key === 'APP_ICON') $settings[$key] = env('APP_URL').Storage::url('app_resources/'.$value);
            }
            
            return $settings;
        } catch (Exception $ex) {
            Log::error('Ha ocurrido un error al consultar los ajustes '.$ex->getMessage());
            abort(500);
        }
    }
}