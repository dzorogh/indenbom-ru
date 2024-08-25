<?php

namespace App\Modules\Family\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyPerson extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function parentCouple(): BelongsTo
    {
        return $this->belongsTo(FamilyCouple::class);
    }

    public function familyCouples(): HasMany
    {
        return $this->hasMany(FamilyCouple::class, 'first_person_id')
            ->orWhere('second_person_id', $this->id);
    }
}
