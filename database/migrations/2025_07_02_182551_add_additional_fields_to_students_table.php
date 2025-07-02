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
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'tingkatan')) {
                $table->string('tingkatan')->nullable()->after('phone_number'); // Grade/Form level
            }
            if (!Schema::hasColumn('students', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('tingkatan'); // Date of birth
            }
            if (!Schema::hasColumn('students', 'gender')) {
                $table->enum('gender', ['Male', 'Female'])->nullable()->after('date_of_birth'); // Gender
            }
            if (!Schema::hasColumn('students', 'parent_guardian_name')) {
                $table->string('parent_guardian_name')->nullable()->after('gender'); // Parent/Guardian name
            }
            if (!Schema::hasColumn('students', 'parent_guardian_phone')) {
                $table->string('parent_guardian_phone')->nullable()->after('parent_guardian_name'); // Parent/Guardian phone
            }
            if (!Schema::hasColumn('students', 'address')) {
                $table->text('address')->nullable()->after('parent_guardian_phone'); // Address
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'tingkatan',
                'date_of_birth', 
                'gender',
                'parent_guardian_name',
                'parent_guardian_phone',
                'address'
            ]);
        });
    }
};
