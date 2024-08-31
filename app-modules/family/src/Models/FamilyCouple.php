<?php

namespace Dzorogh\Family\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyCouple extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function children(): HasMany
    {
        return $this->hasMany(FamilyPerson::class, 'parent_couple_id');
    }

    public function firstPerson(): BelongsTo
    {
        return $this->belongsTo(FamilyPerson::class, 'first_person_id');
    }

    public function secondPerson(): BelongsTo
    {
        return $this->belongsTo(FamilyPerson::class, 'second_person_id');
    }
}
