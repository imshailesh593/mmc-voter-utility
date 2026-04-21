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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('branch')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('registration_number')->nullable()->unique();
            $table->string('serial_number')->nullable();
            $table->timestamps();

            $table->index('phone');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
