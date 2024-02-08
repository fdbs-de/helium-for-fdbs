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
        Schema::create('mfa_methods', function (Blueprint $table) {
            $table->id();
            $table->morphs('authenticatable');
            $table->string('type')->default('totp');
            $table->string('recipient')->nullable();
            $table->string('secret')->nullable();
            $table->timestamp('enabled_at')->nullable();
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
        Schema::dropIfExists('mfa_methods');
    }
};
