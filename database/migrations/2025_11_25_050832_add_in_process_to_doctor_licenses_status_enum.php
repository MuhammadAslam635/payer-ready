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
        // Modify the enum to add 'in_process'
        DB::statement("ALTER TABLE doctor_licenses MODIFY COLUMN status ENUM('pending', 'requested', 'in_process', 'active', 'expired', 'suspended', 'revoked') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'in_process' from the enum
        DB::statement("ALTER TABLE doctor_licenses MODIFY COLUMN status ENUM('pending', 'requested', 'active', 'expired', 'suspended', 'revoked') DEFAULT 'active'");
    }
};
