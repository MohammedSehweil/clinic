<?php

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(__DIR__ .'/facilities.json');

        $institutions = json_decode($json, true);

        foreach ($institutions as $institution) {
            Facility::create([
                'type' => $institution
            ]);
        }
    }
}
