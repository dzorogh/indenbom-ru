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
        Schema::create('family_people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();

            $table->integer('decade_of_birth')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->integer('month_of_birth')->nullable();
            $table->integer('day_of_birth')->nullable();

            $table->integer('decade_of_death')->nullable();
            $table->integer('year_of_death')->nullable();
            $table->integer('month_of_death')->nullable();
            $table->integer('day_of_death')->nullable();

            $table->foreignId('parent_couple_id')->nullable()->constrained(table: 'family_couples');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_people');
    }
};
