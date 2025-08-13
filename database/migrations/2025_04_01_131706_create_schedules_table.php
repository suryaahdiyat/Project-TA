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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Guardian (Wali)
            $table->string('guardian_name');
            $table->string('guardian_relationship');
            $table->string('guardian_father_name');
            $table->date('guardian_birth_date');
            $table->string('guardian_birth_place');
            $table->string('guardian_nationality');
            $table->string('guardian_religion');
            $table->string('guardian_occupation');
            $table->string('guardian_address');

            // Marriage details
            $table->date('marriage_date');
            $table->time('marriage_time');
            $table->string('marriage_venue');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
