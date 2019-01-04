<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class FixUserPasswordsTableSeeder.
 */
class FixUserPasswordsTableSeeder extends Seeder
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

        $users = User::all();

        foreach ($users as $user) {
            $user->update(['password' => bcrypt('secret')]);
            $user->assignRole('administrator');
        }

        $this->enableForeignKeys();
    }
}
