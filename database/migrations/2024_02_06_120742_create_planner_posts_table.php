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
        Schema::create('planner_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_group_id')->constrained('planner_post_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type')->nullable();
            $table->text('content')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
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
        Schema::dropIfExists('planner_posts');
    }
};
