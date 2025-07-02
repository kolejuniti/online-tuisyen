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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->enum('type', ['public', 'private', 'charter', 'international'])->nullable()->after('email');
            $table->integer('total_students')->nullable()->after('type');
            $table->string('teacher_name')->nullable()->after('total_students');
            $table->string('teacher_email')->nullable()->after('teacher_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['email', 'type', 'total_students', 'teacher_name', 'teacher_email']);
        });
    }
};
