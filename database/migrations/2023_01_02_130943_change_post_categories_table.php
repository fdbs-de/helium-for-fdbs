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
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropUnique(['slug']);

            $table->unsignedBigInteger('subcategory_of')->nullable()->after('status');
            $table->string('scope')->nullable()->after('description');
            $table->string('color')->nullable()->after('slug');
            $table->string('icon')->nullable()->after('slug');

            $table->foreign('subcategory_of')->references('id')->on('post_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->unique('slug');
            $table->dropForeign(['subcategory_of']);
            $table->dropColumn('subcategory_of');
            $table->dropColumn('scope');
            $table->dropColumn('color');
            $table->dropColumn('icon');
        });
    }
};
