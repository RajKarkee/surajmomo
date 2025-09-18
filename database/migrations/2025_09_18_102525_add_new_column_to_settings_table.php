<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('primary_color')->default('#e74c3c')->after('site_name');
            $table->string('secondary_color')->default('#27ae60')->after('primary_color');
            $table->string('accent_color')->default('#f39c12')->after('secondary_color');
            $table->string('dark_color')->default('#2c3e50')->after('accent_color');
            $table->string('light_color')->default('#ecf0f1')->after('dark_color');
            $table->string('white_color')->default('#ffffff')->after('light_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('primary_color');
            $table->dropColumn('secondary_color');
            $table->dropColumn('accent_color');
            $table->dropColumn('dark_color');
            $table->dropColumn('light_color');
            $table->dropColumn('white_color');
        });
    }
};
