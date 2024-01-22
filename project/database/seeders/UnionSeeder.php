<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('locationJson/unions.json'));
        $unions = json_decode($json, true);

        foreach ($unions as $union) {
            DB::table('unions')->insert([
                'id' => $union['id'],
                'upazilla_id' => $union['upazilla_id'],
                'name' => $union['name'],
                'bn_name' => $union['bn_name'],
                'url' => $union['url'],
            ]);
        }
    }
}
