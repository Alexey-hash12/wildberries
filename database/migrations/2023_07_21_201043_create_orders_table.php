<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId');
            $table->string('rid')->nullable();
            $table->string('warehouseId')->nullable();
            $table->json('offices')->nullable();
            $table->json('user')->nullable();
            $table->json('skus')->nullable();
            $table->float('price')->default(0);
            $table->float('convertedPrice')->default(0);
            $table->float('currencyCode')->default(0);
            $table->string('orderUid')->nullable();
            $table->string('nmId')->nullable();
            $table->string('chrtId')->nullable();
            $table->string('article')->nullable();
            $table->boolean('isLargeCargo')->default(false);
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
};
