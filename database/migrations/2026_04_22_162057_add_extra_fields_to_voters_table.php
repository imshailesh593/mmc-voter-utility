<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->string('electoral_number')->nullable()->after('registration_number');
            $table->string('degree')->nullable()->after('electoral_number');
            $table->text('address')->nullable()->after('degree');
        });
    }

    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn(['electoral_number', 'degree', 'address']);
        });
    }
};
