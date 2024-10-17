<?php

namespace App\Utils;

use Atomicptr\Functional\Option;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UrlGeneration\PublicUrlGenerator;
use ReflectionClass;

final class UploadUtil
{
    public static function upload(UploadedFile $file, string $dir, string $filename): Option
    {
        $storage = Storage::disk(getenv('APP_UPLOAD_DISK', 'public'));

        $path = $storage->putFileAs($dir, $file, $filename, ['visibility' => 'public']);
        if ($path === false) {
            return Option::none();
        }

        $adapter = self::getAdapter($storage);
        if ($adapter->isNone()) {
            return Option::some($path);
        }

        $adapter = $adapter->value();
        assert($adapter instanceof FilesystemAdapter);

        if ($adapter instanceof PublicUrlGenerator) {
            return Option::some($adapter->publicUrl($path, new Config));
        }

        return Option::some($path);
    }

    private static function getAdapter(Filesystem $fs): Option
    {
        $reflect = new ReflectionClass($fs);
        if (! $reflect->hasProperty('adapter')) {
            return Option::none();
        }

        return Option::some($reflect->getProperty('adapter')->getValue($fs));
    }
}
