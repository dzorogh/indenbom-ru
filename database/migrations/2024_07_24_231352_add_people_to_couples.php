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
            $table->foreignId('first_person_id')->nullable()->constrained(table: 'family_people');
            $table->foreignId('second_person_id')->nullable()->constrained(table: 'family_people');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_couples', function (Blueprint $table) {
            $table->dropForeign(['first_person_id']);
            $table->dropForeign(['second_person_id']);


        });
    }
};
