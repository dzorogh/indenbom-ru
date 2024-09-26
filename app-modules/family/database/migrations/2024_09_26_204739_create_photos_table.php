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
        Schema::create('family_photos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('description')->nullable();
            $table->string('approximate_date')->nullable();
            $table->string('place')->nullable();
        });

        Schema::create('family_person_photo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(\Dzorogh\Family\Models\FamilyPerson::class);
            $table->foreignIdFor(\Dzorogh\Family\Models\FamilyPhoto::class);

            $table->integer('order')->nullable();
            $table->string('position_on_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_photos');
        Schema::dropIfExists('family_person_photo');
    }
};
