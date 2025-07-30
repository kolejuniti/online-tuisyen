<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblmessage_dtl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message_id', 150)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('sender', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('user_type', 25)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->longText('message')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('image_url', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('status', 25)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamp('datetime')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            
            // Add foreign key constraint if needed (commented out since message_id is varchar)
            // $table->foreign('message_id')->references('id')->on('tblmessage')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblmessage_dtl');
    }
};
