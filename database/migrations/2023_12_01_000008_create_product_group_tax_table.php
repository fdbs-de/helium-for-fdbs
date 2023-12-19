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
        Schema::create('product_group_tax', function (Blueprint $table) {
            $table->foreignId('product_group_id')->constrained('product_groups')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tax_id')->constrained('taxes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_group_tax');
    }
};
