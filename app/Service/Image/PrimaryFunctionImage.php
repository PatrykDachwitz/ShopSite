<?php
declare(strict_types=1);
namespace App\Service\Image;

use GdImage;
use Illuminate\Support\Facades\Storage;

abstract class PrimaryFunctionImage
{
    protected const DIRECT_TEMPORARY = 'Temporary/Image/';
    protected const DIRECT_TEMPORARY_PUBLIC = 'app/Temporary/Image/';
    protected const DIRECT_BANNER = 'app/public/banner/';


    protected $functionSaveImage = [
        'jpg' => 'imagejpeg',
        'webp' => 'imagewebp',
        'jpeg' => 'imagejpeg',
        'png' => 'imagepng',
        'gif' => 'imagegif'
    ];

    protected function saveTemporary ($file, $extend) {
        $name = uniqid() . ".{$extend}";
        $file->storeAs(SELF::DIRECT_TEMPORARY, $name);

        return $name;
    }

    public function resize (GdImage $source, int $width, int $height) {
        $image = imagecreatetruecolor($width, $height);
        imagecopyresized($image, $source, 0, 0, 0, 0, $width, $height, $width, $height);

        return $image;
    }

    protected function delete(array $files) {
        foreach ($files as $file) unlink(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $file));
    }

    protected function saveImage (GdImage $image, array $mimeType, int $quality = 75) {
        $name = uniqid();
        foreach ($mimeType as $type) {
            try {
                $this->functionSaveImage[$type]($image, storage_path(SELF::DIRECT_BANNER . "{$name}.{$type}"), $quality);
            } catch (Exception) {
                throw new Exception('Is not available type image');
            }
        }

        return SELF::DIRECT_BANNER . $name;
    }

    protected function getSource($file) {
        $sourceImage = "";
        switch ($file->getMimeType()) {
            case "image/jpg":
                $name = $this->saveTemporary($file, 'jpg');
                $sourceImage = imagecreatefromjpeg(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $name));
                break;
            case "image/webp":
                $name = $this->saveTemporary($file, 'webp');
                $sourceImage = imagecreatefromwebp(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $name));
                break;
            case "image/jpeg":
                $name = $this->saveTemporary($file, 'jpeg');
                $sourceImage = imagecreatefromjpeg(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $name));
                break;
            case "image/png":
                $name = $this->saveTemporary($file, 'png');
                $sourceImage = imagecreatefrompng(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $name));
                break;
            case "image/gif":
                $name = $this->saveTemporary($file, 'gif');
                $sourceImage = imagecreatefromgif(storage_path(SELF::DIRECT_TEMPORARY_PUBLIC . $name));
                break;
        }

        return [
            'source' => $sourceImage,
            'name' => $name
        ];
    }
}
