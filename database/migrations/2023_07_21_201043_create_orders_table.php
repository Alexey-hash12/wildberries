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
            $table->string('incomeId')->nullable()->comment('Id of income');
            $table->string('orderId');
            $table->string('rid')->nullable();
            $table->string('warehouseId')->nullable();
            $table->json('offices')->nullable();
            $table->json('user')->nullable();
            $table->json('skus')->nullable();
            $table->float('price', 15, 2)->default(0);
            $table->float('convertedPrice', 15, 2)->default(0);
            $table->float('currencyCode', 15, 2)->default(0);
            $table->string('orderUid')->nullable();
            $table->string('nmId')->nullable();
            $table->string('chrtId')->nullable();
            $table->string('article')->nullable();
            $table->boolean('isLargeCargo')->default(false);
            $table->dateTime('createdAt')->nullable();
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
