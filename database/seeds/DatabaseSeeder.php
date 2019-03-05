<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // FacilitiesSeeder::class,
        ]);
         Model::unguard();


         $this->call(AuthTableSeeder::class);

         Model::reguard();
    }
}
