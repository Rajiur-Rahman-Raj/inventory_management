<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('locationJson/divisions.json'));
        $divisions = json_decode($json, true);

        foreach ($divisions as $division) {
            DB::table('divisions')->insert([
                'id' => $division['id'],
                'name' => $division['name'],
                'bn_name' => $division['bn_name'],
                'url' => $division['url'],
            ]);
        }
    }
}
