<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ["key" => 'APP_NAME', 'value' => 'Sin nombre'],
            ["key" => 'APP_ICON', 'value' => ''],
        ];
        DB::table('settings')->insert($values);
    }
}
