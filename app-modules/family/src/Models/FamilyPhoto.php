<?php

namespace Dzorogh\Family\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FamilyPhoto extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function registerMediaConversions(Media $media = null): void
    {
        // Автоматическая конверсия при загрузке - гарантирует, что файл является изображением
        // Если файл не изображение, конверсия не сработает и файл не будет сохранен
        // Пережимаем изображение и конвертируем в JPEG для удаления любых метаданных
        $this->addMediaConversion('processed')
            ->performOnCollections('default', 'media')
            ->width(1920)
            ->height(1920)
            ->sharpen(10)
            ->quality(90)
            ->format('jpg')
            ->optimize()
            ->nonQueued();
    }

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
