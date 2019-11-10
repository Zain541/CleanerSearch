<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCleanersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('avatar')->nullable();
            $table->string('company_name', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->unique();
            $table->string('username', 60)->unique();
            $table->string('password');
            $table->string('speciality_other')->nullable();
            $table->unsignedBigInteger('status')->default(0);
            $table->unsignedBigInteger('tracking')->default(0);
            $table->unsignedBigInteger('availability')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cleaners');
    }
}
