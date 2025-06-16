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
        Schema::create('materialsub_url', function (Blueprint $table) {
            $table->id('DrID'); // Corresponds to bigint(20) AUTO_INCREMENT PRIMARY KEY
            $table->string('url', 255)->collation('latin1_swedish_ci');
            $table->longText('description')->collation('latin1_swedish_ci');
            $table->unsignedBigInteger('MaterialDirID')->nullable();
            $table->unsignedBigInteger('MaterialSubDirID')->nullable();
            $table->string('Addby', 100)->nullable()->collation('latin1_swedish_ci');
            // Laravel automatically adds created_at and updated_at timestamps
            // $table->timestamps(); // Add if you need timestamps

            // Assuming MaterialDirID is a foreign key to the material_dir table
            $table->foreign('MaterialDirID')->references('DrID')->on('material_dir')->onDelete('set null');

            // Assuming MaterialSubDirID is a foreign key to the materialsub_dir table
            $table->foreign('MaterialSubDirID')->references('DrID')->on('materialsub_dir')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materialsub_url');
    }
};
