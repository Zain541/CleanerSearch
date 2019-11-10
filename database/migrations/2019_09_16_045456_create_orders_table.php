<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('email', 30);
            $table->string('phone_number', 30);
            $table->string('post_code', 30);
            $table->text('address');
            $table->text('alternative_address')->nullable();
            $table->unsignedBigInteger('property_type_id')->nullable();
            $table->string('property_type', 50)->nullable();
            $table->unsignedBigInteger('contract_type_id')->nullable();
            $table->string('contract_type', 50)->nullable();
            $table->integer('no_of_bedrooms')->unsigned();
            $table->integer('no_of_bathrooms')->unsigned();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('cleaner_id')->nullable();
            $table->string('best_day', 20);
            $table->time('best_time');
            $table->string('cleaning_type', 20);
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
        Schema::dropIfExists('orders');
    }
}
