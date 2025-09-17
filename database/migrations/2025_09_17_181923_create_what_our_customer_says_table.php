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
        Schema::create('what_our_customer_says', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_work')->nullable();
            $table->text('feedback');
            $table->string('customer_image')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('what_our_customer_says');
    }
};
