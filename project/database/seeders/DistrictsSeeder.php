<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('locationJson/districts.json'));
        $districts = json_decode($json, true);

        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'id' => $district['id'],
                'division_id' => $district['division_id'],
                'name' => $district['name'],
                'bn_name' => $district['bn_name'],
                'lat' => $district['lat'],
                'lon' => $district['lon'],
                'url' => $district['url'],
            ]);
        }
    }
}
