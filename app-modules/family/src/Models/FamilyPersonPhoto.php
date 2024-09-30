<?php

namespace Dzorogh\Family\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyPersonPhoto extends Model
{
    use HasFactory;

    protected $table = 'family_person_photo';
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function person(): BelongsTo
    {
        return $this->belongsTo(FamilyPerson::class, 'family_person_id');
    }
}
