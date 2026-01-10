<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Exception;

class MigrateFilesToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:migrate-to-s3
                            {--dry-run : Выполнить без реальной миграции}
                            {--delete-local : Удалить локальные файлы после миграции}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Миграция всех файлов из локального хранилища в S3';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $deleteLocal = $this->option('delete-local');

        if ($dryRun) {
            $this->info('🔍 Режим проверки (dry-run). Файлы не будут загружены.');
        }

        // Проверяем подключение к S3
        if (!$dryRun && !$this->checkS3Connection()) {
            $this->error('❌ Не удалось подключиться к S3. Проверьте настройки в .env');
            return Command::FAILURE;
        }

        $localDisk = Storage::disk('public');
        $s3Disk = Storage::disk('s3');

        // Получаем все записи media, которые хранятся локально
        $mediaRecords = Media::whereIn('disk', ['public', 'local'])->get();

        if ($mediaRecords->isEmpty()) {
            $this->info('✅ Нет файлов для миграции.');
            return Command::SUCCESS;
        }

        $this->info("📦 Найдено {$mediaRecords->count()} записей для миграции.");

        $progressBar = $this->output->createProgressBar($mediaRecords->count());
        $progressBar->start();

        $successCount = 0;
        $errorCount = 0;
        $skippedCount = 0;

        foreach ($mediaRecords as $media) {
            try {
                // Получаем путь к файлу относительно корня диска
                // Spatie Media Library хранит файлы в структуре: {id}/{file_name}
                $relativePath = $media->id . '/' . $media->file_name;

                // Проверяем существование файла
                if (!$localDisk->exists($relativePath)) {
                    $this->newLine();
                    $this->warn("⚠️  Файл не найден: {$relativePath} (ID: {$media->id})");
                    $skippedCount++;
                    $progressBar->advance();
                    continue;
                }

                if (!$dryRun) {
                    // Загружаем основной файл в S3
                    $fileContent = $localDisk->get($relativePath);
                    $s3Disk->put($relativePath, $fileContent, 'public');

                    // Обрабатываем конверсии
                    $conversions = $media->getGeneratedConversions();
                    foreach ($conversions as $conversionName => $isGenerated) {
                        if ($isGenerated) {
                            // Формируем имя файла конверсии: {conversion_name}-{file_name}
                            $conversionFileName = $conversionName . '-' . $media->file_name;
                            $conversionRelativePath = $media->id . '/conversions/' . $conversionFileName;

                            if ($localDisk->exists($conversionRelativePath)) {
                                $conversionContent = $localDisk->get($conversionRelativePath);
                                $s3Disk->put($conversionRelativePath, $conversionContent, 'public');
                            }
                        }
                    }

                    // Обрабатываем responsive images
                    $responsiveImages = $media->responsive_images ?? [];
                    foreach ($responsiveImages as $conversionName => $responsiveImageData) {
                        if (isset($responsiveImageData['urls'])) {
                            foreach ($responsiveImageData['urls'] as $url) {
                                // Извлекаем путь из URL
                                $urlParts = parse_url($url);
                                $responsivePath = ltrim($urlParts['path'] ?? '', '/');

                                // Убираем префикс /storage/ если есть
                                $responsivePath = str_replace('storage/', '', $responsivePath);

                                if ($localDisk->exists($responsivePath)) {
                                    $responsiveContent = $localDisk->get($responsivePath);
                                    $s3Disk->put($responsivePath, $responsiveContent, 'public');
                                }
                            }
                        }
                    }

                    // Обновляем запись в базе данных
                    $media->disk = 's3';
                    if ($media->conversions_disk && $media->conversions_disk !== 's3') {
                        $media->conversions_disk = 's3';
                    }
                    $media->save();

                    // Удаляем локальный файл, если указана опция
                    if ($deleteLocal) {
                        $localDisk->delete($relativePath);

                        // Удаляем конверсии
                        foreach ($conversions as $conversionName => $isGenerated) {
                            if ($isGenerated) {
                                $conversionFileName = $conversionName . '-' . $media->file_name;
                                $conversionRelativePath = $media->id . '/conversions/' . $conversionFileName;
                                if ($localDisk->exists($conversionRelativePath)) {
                                    $localDisk->delete($conversionRelativePath);
                                }
                            }
                        }
                    }
                }

                $successCount++;
            } catch (Exception $e) {
                $errorCount++;
                $this->newLine();
                $this->error("❌ Ошибка при миграции файла ID {$media->id}: {$e->getMessage()}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Выводим статистику
        $this->info("✅ Успешно мигрировано: {$successCount}");
        if ($skippedCount > 0) {
            $this->warn("⚠️  Пропущено: {$skippedCount}");
        }
        if ($errorCount > 0) {
            $this->error("❌ Ошибок: {$errorCount}");
        }

        if ($dryRun) {
            $this->info('💡 Для реальной миграции запустите команду без флага --dry-run');
        }

        return $errorCount > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * Проверка подключения к S3
     */
    private function checkS3Connection(): bool
    {
        try {
            $s3Disk = Storage::disk('s3');
            $testPath = 'test-connection-' . time() . '.txt';
            $s3Disk->put($testPath, 'test');
            $s3Disk->delete($testPath);
            return true;
        } catch (Exception $e) {
            $this->error("Ошибка подключения к S3: {$e->getMessage()}");
            return false;
        }
    }
}
