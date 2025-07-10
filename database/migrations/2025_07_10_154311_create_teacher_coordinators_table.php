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
        Schema::create('teacher_coordinators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('secret_code', 20)->unique();
            $table->timestamps();
            
            // Ensure each school can only have one coordinator
            $table->unique('school_id');
            
            // Add index for secret_code for faster lookups
            $table->index('secret_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_coordinators');
    }
};
