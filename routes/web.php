<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// Прокси-роут для файлов из S3
// Обрабатывает запросы вида: /{id}/{filename} для медиа файлов
Route::get('/{id}/{filename}', function (string $id, string $filename) {
    // Проверяем, существует ли запись в базе данных
    $media = Media::find($id);
    
    if (!$media || $media->file_name !== $filename || $media->disk !== 's3') {
        abort(404);
    }
    
    $path = $id . '/' . $filename;
    
    // Проверяем, существует ли файл в S3
    if (!Storage::disk('s3')->exists($path)) {
        abort(404);
    }
    
    // Получаем файл из S3
    $file = Storage::disk('s3')->get($path);
    $mimeType = Storage::disk('s3')->mimeType($path) ?: $media->mime_type ?: 'application/octet-stream';
    
    return response($file, 200)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'public, max-age=31536000, immutable')
        ->header('Content-Length', strlen($file));
})->where(['id' => '\d+', 'filename' => '[^/]+']);

// Прокси-роут для конверсий: /{id}/conversions/{filename}
Route::get('/{id}/conversions/{filename}', function (string $id, string $filename) {
    // Проверяем, существует ли запись в базе данных
    $media = Media::find($id);
    
    if (!$media || $media->disk !== 's3') {
        abort(404);
    }
    
    $path = $id . '/conversions/' . $filename;
    
    if (!Storage::disk('s3')->exists($path)) {
        abort(404);
    }
    
    $file = Storage::disk('s3')->get($path);
    $mimeType = Storage::disk('s3')->mimeType($path) ?: 'image/jpeg';
    
    return response($file, 200)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'public, max-age=31536000, immutable')
        ->header('Content-Length', strlen($file));
})->where(['id' => '\d+', 'filename' => '[^/]+']);

//Route::get('/', function () {
//    return view('welcome');
//});
//
