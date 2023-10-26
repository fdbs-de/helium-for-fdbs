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
        Schema::create('significant_dates', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('dateable');
            $table->string('type')->nullable();
            $table->date('date');
            $table->boolean('ignore_year')->default(false);
            $table->boolean('repeats_annually')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('significant_dates');
    }
};
