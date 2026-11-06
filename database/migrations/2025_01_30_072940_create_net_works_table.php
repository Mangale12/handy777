<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_works', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('symbol')->unique(); // Example: BTC, ETH
            $table->string('icon')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('has_multiple_coins')->default(false);
            $table->string('default_address')->nullable(); // Used when no multiple coins exist
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
        Schema::dropIfExists('net_works');
    }
}
