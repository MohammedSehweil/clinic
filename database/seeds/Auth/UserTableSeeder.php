<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
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

        // Add the master administrator, user id of 1
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'admin'
        ]);

        User::create([
            'first_name' => 'Doctor',
            'last_name' => 'Ali',
            'email' => 'doctor@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'doctor'

        ]);

        User::create([
            'first_name' => 'Patient',
            'last_name' => 'Samer',
            'email' => 'patient@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'patient'
        ]);


        User::create([
            'first_name' => 'Clinic',
            'last_name' => 'Owner',
            'email' => 'owner@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'owner'
        ]);


        User::create([
            'first_name' => 'Private',
            'last_name' => 'Doctor',
            'email' => 'privatedoctor@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'private-doctor',
            'info_filled' => false,
            'country_id' => '1',
            'city' => 'Ramallah',
            'description' => 'this is description',
        ]);


        User::create([
            'first_name' => 'Nurse',
            'last_name' => 'Nurse',
            'email' => 'nurse@gmail.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'type' => 'nurse',
            'info_filled' => false,
            'country_id' => '2',
            'city' => 'Nablus',
            'description' => 'this is description .. ',
        ]);



        $this->enableForeignKeys();
    }
}
