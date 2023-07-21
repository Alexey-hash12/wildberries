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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('incomeId');
            $table->boolean('done')->default(false);
            $table->dateTime('createdAt')->nullable();
            $table->dateTime('closedAt')->nullable();
            $table->dateTime('scanDt')->nullable();
            $table->string('name')->nullable();
            $table->boolean('isLargeCargo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
};
