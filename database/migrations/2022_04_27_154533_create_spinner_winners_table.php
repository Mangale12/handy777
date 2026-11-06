<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpinnerWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spinner_winners', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();

            
               $table->string('address')->nullable();
             $table->dateTime('intervals');
             $table->string('count');
            $table->string('note')->nullable();
             $table->tinyInteger('status')->default('0');
            $table->string('r_id')->nullable();
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
        Schema::dropIfExists('spinner_winners');
    }
}
