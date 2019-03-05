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
            'approved' => true,
            'owner_id' => 4,
            'country_id' => 170,
            'city' => 'Ramallah',
            'service_location' => 'home',
        ]);

        $second = \App\Models\Auth\Clinic::create([
            'name' => 'second clinic',
            'approved' => true,
            'owner_id' => 4,
            'country_id' => 170,
            'city' => 'Nablus',
            'service_location' => 'clinic',



        ]);

        $third = \App\Models\Auth\Clinic::create([
            'name' => 'third clinic',
            'approved' => false,
            'owner_id' => 4,
            'country_id' => 170,
            'city' => 'Nablus',


        ]);


        foreach (range(4, 9, 1) as $i){
            \App\Models\Auth\Clinic::create([
                'name' => 'clinic #'.$i,
                'approved' => false,
                'owner_id' => 4,
                'country_id' => 170,
                'city' => 'Ramallah',


            ]);


            \App\Models\Auth\Specialties::query()->create([
                'name' => 'Spec #'.$i,
            ]);

        }


        $firstSpecialties = \App\Models\Auth\Specialties::query()->create([
            'name' => 'طب الاسنان',
        ]);

        $secondSpecialties = \App\Models\Auth\Specialties::query()->create([
            'name' => 'أمراض الدم',
        ]);

        $thirdSpecialties = \App\Models\Auth\Specialties::query()->create([
            'name' => 'عيون',
        ]);

        $fourthSpecialties = \App\Models\Auth\Specialties::query()->create([
            'name' => 'جراحة',
            'description' => 'ُتعتبر الجراحة إحدى التخصصات الطبية التي تستخدم بعض الأدوات الطبية مثل المشرط، بالإضافة إلى بعض الإجراءات اليدوية لعمل شق في جسم المريض إجراء اللازم، ومن ثم إغلاق الشق بالخياطة باستخدام خيوط طبية خاصة وبمواصفات معينة.'
        ]);

        $fifthSpecialties = \App\Models\Auth\Specialties::query()->create([
            'name' => 'نفسي',
            'description' => 'هو الفرع أو التخصص الذي يهتم بالاضطرابات النفسية، ويقوم بتشخيصها وعلاجها أحياناً والوقاية منها، وهذه الاضطرابات قد تكون عقلية أو سلوكية، تنشأ نتيجة خطأ معين في عمل الدماغ، أو نتيجة التعرض إلى صدمة غير متوقعة.'
        ]);




        $first->specialties()->sync([
            $firstSpecialties->id,
            $secondSpecialties->id,
            $thirdSpecialties->id,
        ]);


        $second->specialties()->sync([
            $secondSpecialties->id,
            $thirdSpecialties->id,
            $fourthSpecialties->id,
            $fifthSpecialties->id,
        ]);


        $doctors = [];
        foreach (range(1, 6) as $doctorNum) {
            $doctor = User::create([
                'first_name' => 'Doc',
                'last_name' => $doctorNum,
                'email' => "doctor$doctorNum@gmail.com",
                'password' => 'secret',
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'type' => 'doctor'
            ]);

            $doctors[] = $doctor;
        }


        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[0]->id,
            'clinic_specialties_id' => 1
        ]);

        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[1]->id,
            'clinic_specialties_id' => 1
        ]);

        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[2]->id,
            'clinic_specialties_id' => 2
        ]);
        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[3]->id,
            'clinic_specialties_id' => 3
        ]);

        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[4]->id,
            'clinic_specialties_id' => 4
        ]);

        \App\Models\Auth\UserClinicSpecialties::query()->create([
            'user_id' => $doctors[5]->id,
            'clinic_specialties_id' => 4
        ]);


        foreach (User::all() as $user) {
            $user->assignRole(config('access.users.admin_role'));
        }


        $this->enableForeignKeys();
    }
}
