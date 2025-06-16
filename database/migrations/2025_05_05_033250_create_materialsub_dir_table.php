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
        Schema::create('materialsub_dir', function (Blueprint $table) {
            $table->id('DrID'); // Corresponds to bigint(20) AUTO_INCREMENT PRIMARY KEY
            $table->decimal('SubChapterNo', 10, 1);
            $table->string('DrName', 100)->nullable()->collation('latin1_swedish_ci');
            $table->string('newDrName', 100)->nullable()->collation('latin1_swedish_ci');
            $table->string('Password', 255)->nullable()->collation('utf8mb4_general_ci');
            $table->unsignedBigInteger('MaterialDirID')->nullable();
            $table->string('Addby', 100)->nullable()->collation('latin1_swedish_ci');
            // Laravel automatically adds created_at and updated_at timestamps
            // $table->timestamps(); // Add if you need timestamps

            // Assuming MaterialDirID is a foreign key to the material_dir table
            $table->foreign('MaterialDirID')->references('DrID')->on('material_dir')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materialsub_dir');
    }
};
