<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClinicUserTable.
 */
class CreateClinicUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_user', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('clinic_id')->index();
            $table->unsignedInteger('user_id')->index();


            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_user');
    }
}
