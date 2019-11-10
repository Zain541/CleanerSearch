<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabeCleanerSpecialityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaner_speciality', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cleaner_id');
            $table->unsignedBigInteger('speciality_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cleaner_speciality');
    }
}
