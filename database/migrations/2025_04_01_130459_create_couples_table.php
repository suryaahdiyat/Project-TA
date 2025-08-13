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
        Schema::create('couples', function (Blueprint $table) {
            $table->id();

            // Groom
            $table->string('groom_name');
            $table->string('groom_photo')->nullable();
            $table->string('groom_father_name');
            $table->string('groom_mother_name');
            $table->string('groom_marital_status');
            $table->date('groom_birth_date');
            $table->string('groom_birth_place');
            $table->string('groom_nationality');
            $table->string('groom_religion');
            $table->string('groom_occupation');
            $table->string('groom_address');
            $table->string('groom_email')->unique();

            // Bride
            $table->string('bride_name');
            $table->string('bride_photo')->nullable();
            $table->string('bride_father_name');
            $table->string('bride_mother_name');
            $table->string('bride_marital_status');
            $table->date('bride_birth_date');
            $table->string('bride_birth_place');
            $table->string('bride_nationality');
            $table->string('bride_religion');
            $table->string('bride_occupation');
            $table->string('bride_address');
            $table->string('bride_email')->unique();

            $table->string('marriage_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couples');
    }
};
