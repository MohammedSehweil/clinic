<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class AppointmentTableSeeder.
 */
class AppointmentTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Auth\Appointment::query()
            ->create([
                'doctor_id' => 1,
                'patient_id' => 1,
                'clinic_id' => 7,
                'start_at' => \Carbon\Carbon::now()->format('Y-m-d'),
                'service_type' => 0,
                'reserved' => true,
            ]);

    }
}
