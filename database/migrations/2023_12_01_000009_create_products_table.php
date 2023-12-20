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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_group_id')->constrained('product_groups')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('type');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('base_unit')->nullable();
            $table->string('base_unit_amount')->nullable();
            $table->boolean('is_shown')->default(false);
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
        Schema::dropIfExists('products');
    }
};
