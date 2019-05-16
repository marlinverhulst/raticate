<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('address');
            $table->string('zip')->nullable();
            $table->string('tel')->nullable();
            $table->string('city');
            $table->integer('client_id')->index()->unsigned();
            $table->integer('pricetag_id')->index()->unsigned()->nullable();
            $table->integer('user_id')->index()->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->date('visitdate')->nullable();
           
            $table->text('comments')->nullable();
            $table->boolean('callfirst');
            $table->string('message')->nullable();
            $table->string('time')->nullable();
            $table->boolean('done');
            $table->string('cause')->nullable();
            $table->integer('priority')->default('0');





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
        Schema::dropIfExists('jobs');
    }
}
