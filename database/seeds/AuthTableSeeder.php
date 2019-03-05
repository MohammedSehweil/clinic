<?php

use Illuminate\Database\Seeder;

/**
 * Class AuthTableSeeder.
 */
class AuthTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();


        $this->call(CountriesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);

        $this->call(ClinicTableSeeder::class);
        $this->call(AppointmentTableSeeder::class);

        $this->enableForeignKeys();
    }
}
