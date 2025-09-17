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
        Schema::table('abouts', function (Blueprint $table) {
            $table->string('what_we_do_img')->nullable()->after('what_we_do');
            $table->string('our_story_img')->nullable()->after('our_story');
        });
    }

    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn(['what_we_do_img', 'our_story_img']);
        });
    }
};
