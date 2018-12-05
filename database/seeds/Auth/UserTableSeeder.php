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

        $this->enableForeignKeys();
    }
}
