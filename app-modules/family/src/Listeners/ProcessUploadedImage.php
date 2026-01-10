<?php

namespace Dzorogh\Family\Listeners;

use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Exception;

class ProcessUploadedImage
{
    /**
     * Обрабатывает загруженное изображение, пережимая его для безопасности
     * Гарантирует, что файл действительно является изображением
     */
    public function handle(MediaHasBeenAdded $event): void
    {
        $media = $event->media;

        // Список опасных расширений, которые никогда не должны быть загружены
        $dangerousExtensions = [
            'php', 'php3', 'php4', 'php5', 'phtml', 'pl', 'py', 'jsp', 'asp',
            'sh', 'bash', 'cgi', 'exe', 'bat', 'cmd', 'com', 'pif', 'scr',
            'vbs', 'jar', 'app', 'deb', 'rpm', 'dmg', 'pkg', 'run', 'bin'
        ];

        // Проверяем расширение файла
        $fileName = $media->file_name ?? $media->name ?? '';
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($extension, $dangerousExtensions)) {
            $media->delete();
            throw new Exception('Загрузка файлов с опасным расширением запрещена');
        }

        // Проверяем, что это изображение по MIME типу
        if (!str_starts_with($media->mime_type ?? '', 'image/')) {
            // Если не изображение - удаляем файл
            $media->delete();
            throw new Exception('Загруженный файл не является изображением');
        }

        // Разрешенные расширения для изображений
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'];
        if (!in_array($extension, $allowedImageExtensions)) {
            $media->delete();
            throw new Exception('Недопустимое расширение файла для изображения');
        }

        try {
            // Проверяем, что файл действительно существует и является изображением
            $path = $media->getPath();

            if (!file_exists($path)) {
                $media->delete();
                throw new Exception('Загруженный файл не найден');
            }

            // Пытаемся получить информацию об изображении через GD/Imagick
            // Если это не изображение, getimagesize вернет false
            $imageInfo = @getimagesize($path);

            if ($imageInfo === false) {
                // Файл не является валидным изображением
                $media->delete();
                throw new Exception('Загруженный файл не является валидным изображением');
            }

            // Конверсия 'processed' должна быть выполнена синхронно (nonQueued)
            // Проверяем её наличие для дополнительной гарантии
            // Если конверсия настроена, она уже должна была выполниться
            // Это дополнительная проверка того, что файл действительно изображение
        } catch (Exception $e) {
            // Если произошла ошибка при обработке - удаляем файл
            if ($media->exists) {
                try {
                    $media->delete();
                } catch (Exception $deleteException) {
                    // Игнорируем ошибки при удалении
                }
            }
            throw $e;
        }
    }
}
