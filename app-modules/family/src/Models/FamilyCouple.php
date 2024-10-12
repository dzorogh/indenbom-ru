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

    public function husband(): BelongsTo
    {
        return $this->belongsTo(FamilyPerson::class, 'husband_id');
    }

    public function wife(): BelongsTo
    {
        return $this->belongsTo(FamilyPerson::class, 'wife_id');
    }
}
