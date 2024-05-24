<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone', 20);
            $table->string('email', 100);
            $table->string('message', 1000)->nullable();

            $table->string('comune', 50)->default('0');
            $table->string('indirizzo', 100)->default('0');
            $table->string('civico', 30)->default('0');
            
            $table->unsignedBigInteger('total_price')->default(0);
            $table->smallInteger('total_pz_q');
            $table->smallInteger('total_pz_t');
            $table->string('date_slot', 16);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
