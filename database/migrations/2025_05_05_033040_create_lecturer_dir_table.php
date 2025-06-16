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
        Schema::create('lecturer_dir', function (Blueprint $table) {
            $table->id('DrID'); // Corresponds to bigint(20) AUTO_INCREMENT PRIMARY KEY
            $table->string('DrName', 100)->nullable()->collation('latin1_swedish_ci');
            $table->string('newDrName', 100)->nullable()->collation('latin1_swedish_ci');
            $table->string('Password', 255)->nullable()->collation('utf8mb4_general_ci');
            $table->string('CourseID', 20)->nullable()->collation('latin1_swedish_ci');
            // Skipping the crossed-out column
            $table->string('Addby', 100)->nullable()->collation('latin1_swedish_ci');
            // Laravel automatically adds created_at and updated_at timestamps
            // $table->timestamps(); // Add if you need timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_dir');
    }
};
