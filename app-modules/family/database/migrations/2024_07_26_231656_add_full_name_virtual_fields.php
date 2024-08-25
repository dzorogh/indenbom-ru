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
        Schema::table('family_people', function (Blueprint $table) {
            $table
                ->string('full_name')
                // concat with nullable fix
                ->virtualAs("CONCAT_WS(' ', `first_name`, `middle_name`, `last_name`)");
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
