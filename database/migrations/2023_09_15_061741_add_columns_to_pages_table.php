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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('parent_of')->nullable()->constrained('pages')->onDelete('set null');
            $table->boolean('strict_permissions')->default(false);
            $table->boolean('require_auth')->default(false);
            $table->boolean('require_verification')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_of']);
            $table->dropColumn('parent_of');
            $table->dropColumn('strict_permissions');
            $table->dropColumn('require_auth');
            $table->dropColumn('require_verification');
        });
    }
};
