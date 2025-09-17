<?php

use App\Enums\UserType;
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
        // For PostgreSQL, we need to drop and recreate the enum constraint
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_user_type_check');

        // Get all current UserType values
        $userTypes = array_keys(UserType::options());

        // Create the new check constraint with all current values
        $constraint = "user_type IN ('" . implode("', '", $userTypes) . "')";
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_user_type_check CHECK ($constraint)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the constraint
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_user_type_check');

        // Restore the original constraint (without organization_admin)
        $originalTypes = ['doctor', 'clinic_manager', 'clinic_staff', 'super_admin', 'coordinator'];
        $constraint = "user_type IN ('" . implode("', '", $originalTypes) . "')";
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_user_type_check CHECK ($constraint)");
    }
};
