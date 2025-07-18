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
            // Check if addby column doesn't exist before adding it
            if (!Schema::hasColumn('online_class', 'addby')) {
                $table->string('addby')->nullable()->after('status')->comment('Teacher IC who created the class');
            }
            
            // Check if subject_id column doesn't exist before adding it
            if (!Schema::hasColumn('online_class', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('addby');
            }
        });

        // Add foreign key constraint for subject_id if it doesn't exist
        if (Schema::hasColumn('online_class', 'subject_id')) {
            try {
                Schema::table('online_class', function (Blueprint $table) {
                    $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist, ignore the error
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_class', function (Blueprint $table) {
            // Drop foreign key constraint if it exists
            if (Schema::hasColumn('online_class', 'subject_id')) {
                try {
                    $table->dropForeign(['subject_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, ignore the error
                }
            }
            
            // Drop columns if they exist
            if (Schema::hasColumn('online_class', 'subject_id')) {
                $table->dropColumn('subject_id');
            }
            
            if (Schema::hasColumn('online_class', 'addby')) {
                $table->dropColumn('addby');
            }
        });
    }
};
