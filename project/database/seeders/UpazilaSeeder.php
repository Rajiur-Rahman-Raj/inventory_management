<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('locationJson/upazilas.json'));
        $upazilas = json_decode($json, true);

        foreach ($upazilas as $upazila) {
            DB::table('upazilas')->insert([
                'id' => $upazila['id'],
                'district_id' => $upazila['district_id'],
                'name' => $upazila['name'],
                'bn_name' => $upazila['bn_name'],
                'url' => $upazila['url'],
            ]);
        }
    }
}
