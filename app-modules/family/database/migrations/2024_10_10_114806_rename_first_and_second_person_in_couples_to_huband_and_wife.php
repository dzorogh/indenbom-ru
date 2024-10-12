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
        Schema::table('family_couples', function (Blueprint $table) {
            $table->renameColumn("first_person_id", "husband_id");
            $table->renameColumn("second_person_id", "wife_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_couples', function (Blueprint $table) {
            $table->renameColumn("husband_id", "first_person_id");
            $table->renameColumn("wife_id", "second_person_id");
        });
    }
};
