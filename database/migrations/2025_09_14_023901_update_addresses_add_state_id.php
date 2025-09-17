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
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade')->after('city');
        });

        // Migrate existing state data to use state_id
        $addresses = DB::table('addresses')->whereNotNull('state')->get();

        foreach ($addresses as $address) {
            $state = DB::table('states')->where('code', $address->state)->first();
            if ($state) {
                DB::table('addresses')
                    ->where('id', $address->id)
                    ->update(['state_id' => $state->id]);
            }
        }

        // Now we can drop the old state column
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the state column
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('state')->after('city');
        });

        // Migrate state_id back to state code
        $addresses = DB::table('addresses')
            ->join('states', 'addresses.state_id', '=', 'states.id')
            ->select('addresses.id', 'states.code')
            ->get();

        foreach ($addresses as $address) {
            DB::table('addresses')
                ->where('id', $address->id)
                ->update(['state' => $address->code]);
        }

        // Drop the foreign key and state_id column
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });
    }
};
