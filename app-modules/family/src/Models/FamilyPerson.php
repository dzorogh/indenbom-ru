<?php

namespace Dzorogh\Family\Models;

use Dzorogh\Family\Enums\DatePrecision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyPerson extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'birth_date_precision' => DatePrecision::class,
        'death_date_precision' => DatePrecision::class,
    ];

    public function parentCouple(): BelongsTo
    {
        return $this->belongsTo(FamilyCouple::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(FamilyPersonContact::class, 'family_person_id');
    }
}
