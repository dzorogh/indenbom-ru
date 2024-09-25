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
        Schema::create('family_person_contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(\Dzorogh\Family\Models\FamilyPerson::class);
            $table->enum('type', [
                'facebook',
                'linkedin',
                'wikipedia',
                'vk',
                'email',
                'phone',
                'telegram',
                'whatsapp',
                'viber',
                'website',
                'archive'
            ]);
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_person_contacts');
    }
};
