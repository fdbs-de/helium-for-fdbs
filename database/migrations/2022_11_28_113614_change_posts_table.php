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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('title');
            $table->foreignId('category')->nullable()->constrained('post_categories')->nullOnDelete()->cascadeOnUpdate()->after('slug');
            $table->string('status')->default('draft')->after('pinned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropForeign(['category']);
            $table->dropColumn('category');
            $table->dropColumn('status');
        });
    }
};
