<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class ClinicTableSeeder.
 */
class ClinicTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $first = \App\Models\Auth\Clinic::create([
            'name' => 'first clinic',
        ]);

        $second = \App\Models\Auth\Clinic::create([
            'name' => 'second clinic',
        ]);

        $doctor = \App\Models\Auth\Doctor::find(2);

        $doctor->clinics()->sync([$first->id, $second->id]);
//        $doctor->assignRole(config('access.users.admin_role'));


        $this->enableForeignKeys();
    }
}
