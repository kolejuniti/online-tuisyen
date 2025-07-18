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
        Schema::table('online_class', function (Blueprint $table) {
            $table->string('addby')->nullable()->after('status')->comment('Teacher IC who created the class');
            $table->unsignedBigInteger('subject_id')->nullable()->after('addby');
            
            // Add foreign key constraint for subject_id
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_class', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['addby', 'subject_id']);
        });
    }
};
