<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });
    

        DB::table('statuses')->insert(
           ['name'=> 'Pending']
        );
         DB::table('statuses')->insert(
           ['name'=> 'Approved']
        );
          DB::table('statuses')->insert(
           ['name'=> 'Rejected']
        );
           DB::table('statuses')->insert(
           ['name'=> 'Withdraw']
        );
           DB::table('statuses')->insert(
           ['name'=> 'Completed']
        );

           DB::table('statuses')->insert(
           ['name'=> 'Active']
        );

            DB::table('statuses')->insert(
           ['name'=> 'De active']
        );

            DB::table('statuses')->insert(
           ['name'=> 'Disapproved']
        );

             DB::table('statuses')->insert(
           ['name'=> 'On Hold']
        );
    }

    /* Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
