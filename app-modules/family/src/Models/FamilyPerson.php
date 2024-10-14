<?php

namespace Dzorogh\Family\Models;

use Dzorogh\Family\Enums\DatePrecision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FamilyPerson extends Model implements HasMedia
{
    use InteractsWithMedia, Searchable;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'birth_date_precision' => DatePrecision::class,
        'death_date_precision' => DatePrecision::class,
    ];

    public function parentCouple(): BelongsTo
    {
        return $this->belongsTo(FamilyCouple::class);
    }

    public function couplesHusband(): HasMany
    {
        return $this->hasMany(
            FamilyCouple::class,
            'husband_id',
        );
    }

    public function couplesWife(): HasMany
    {
        return $this->hasMany(
            FamilyCouple::class,
            'wife_id',
        );
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(FamilyPersonContact::class, 'family_person_id');
    }

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(FamilyPhoto::class, 'family_person_photo')
            ->withPivot(['order']);
    }
}
