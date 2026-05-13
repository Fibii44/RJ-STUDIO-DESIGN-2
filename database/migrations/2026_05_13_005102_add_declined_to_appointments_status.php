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
        // For Postgres (Supabase), we need to handle the enum constraint update
        // The easiest way is to change the column to string, which removes the enum constraint
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the enum constraint if it exists (standard Laravel/Postgres behavior)
            DB::statement("ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check");
            
            // Change status to string to allow any status value (more flexible)
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Revert back to enum if needed (might fail if 'declined' values exist)
            // $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending')->change();
        });
    }
};
