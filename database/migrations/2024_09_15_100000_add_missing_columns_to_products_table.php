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
        Schema::table('products', function (Blueprint $table) {
            // Drop the old columns if they exist
            if (Schema::hasColumn('products', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
            
            // Add new columns
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('active')->after('category');
            }
            if (!Schema::hasColumn('products', 'image_url')) {
                $table->string('image_url')->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'ingredients')) {
                $table->text('ingredients')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('products', 'spice_level')) {
                $table->enum('spice_level', ['mild', 'medium', 'spicy', 'very_spicy'])->nullable()->after('ingredients');
            }
            
            // Update category column to allow more values
            $table->string('category')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['status', 'image_url', 'ingredients', 'spice_level']);
            $table->boolean('is_active')->default(true);
            $table->string('image');
        });
    }
};
