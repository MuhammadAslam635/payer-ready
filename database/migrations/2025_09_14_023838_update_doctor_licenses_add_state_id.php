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
        // First, add the new state_id column
        Schema::table('doctor_licenses', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade')->after('license_type_id');
        });

        // Migrate existing state data to use state_id
        $licenses = DB::table('doctor_licenses')->whereNotNull('state')->get();

        foreach ($licenses as $license) {
            $state = DB::table('states')->where('code', $license->state)->first();
            if ($state) {
                DB::table('doctor_licenses')
                    ->where('id', $license->id)
                    ->update(['state_id' => $state->id]);
            }
        }

        // Now we can drop the old state column
        Schema::table('doctor_licenses', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the state column
        Schema::table('doctor_licenses', function (Blueprint $table) {
            $table->string('state')->after('license_type_id');
        });

        // Migrate state_id back to state code
        $licenses = DB::table('doctor_licenses')
            ->join('states', 'doctor_licenses.state_id', '=', 'states.id')
            ->select('doctor_licenses.id', 'states.code')
            ->get();

        foreach ($licenses as $license) {
            DB::table('doctor_licenses')
                ->where('id', $license->id)
                ->update(['state' => $license->code]);
        }

        // Drop the foreign key and state_id column
        Schema::table('doctor_licenses', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });
    }
};
