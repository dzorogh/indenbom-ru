<?php

namespace Dzorogh\Family\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FamilyPhoto extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function peoplePhotos(): HasMany
    {
        return $this->hasMany(FamilyPersonPhoto::class);
    }

    public function people(): BelongsToMany
    {
        return $this
            ->belongsToMany(FamilyPerson::class, 'family_person_photo')
            ->withPivot(['position_on_photo']);
    }
}
