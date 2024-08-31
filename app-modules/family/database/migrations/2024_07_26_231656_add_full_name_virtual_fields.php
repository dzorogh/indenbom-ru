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
        DB::statement("CREATE OR REPLACE FUNCTION immutable_concat_ws(text, VARIADIC text[])
          RETURNS text
          LANGUAGE internal IMMUTABLE PARALLEL SAFE AS
        'text_concat_ws';");

        Schema::table('family_people', function (Blueprint $table) {
            $table
                ->string('full_name')
                // concat with nullable fix
                ->storedAs("immutable_concat_ws(' ', first_name, middle_name, last_name)");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_people', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });
    }
};
