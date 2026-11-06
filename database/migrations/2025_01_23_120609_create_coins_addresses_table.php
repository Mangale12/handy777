<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('network')->nullable(); // Network field
            $table->string('address')->nullable(); // Coin address field
            $table->string('logo')->nullable(); // Logo field (nullable for optional upload)
            $table->string('qr')->nullable(); // QR field (nullable)
            $table->boolean('status')->default(0); // Status field (default to 0 for unchecked)
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
        Schema::dropIfExists('coins_addresses');
    }
}
