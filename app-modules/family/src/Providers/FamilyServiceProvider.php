<?php

namespace Dzorogh\Family\Providers;

use Dzorogh\Family\Listeners\ProcessUploadedImage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class FamilyServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}

	public function boot(): void
	{
		// Регистрируем обработчик для пережатия изображений при загрузке
		Event::listen(
			MediaHasBeenAdded::class,
			ProcessUploadedImage::class
		);
	}
}
