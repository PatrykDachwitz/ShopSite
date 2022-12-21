<?php
declare(strict_types=1);
namespace App\Service\Image;

class BannerCreate extends PrimaryFunctionImage
{
    protected const RESOLUTION_IMAGE = [
        'pc' => [
            'width' => 1480,
            'height' => 700
            ],
        'mobile' => [
            'width' => 620,
            'height' => 420
            ]
        ];

    public function uploude(array $deviceFile) {
        $imagesDetail = [];
        foreach ($deviceFile as $device => $files) {
            foreach ($files as $key => $file) {
                $source = $this->getSource($file);
                switch ($device) {
                    case "pc":
                        $image = $this->resize($source['source'], SELF::RESOLUTION_IMAGE['pc']['width'], SELF::RESOLUTION_IMAGE['pc']['height']);
                        break;
                    case "mobile":
                        $image = $this->resize($source['source'], SELF::RESOLUTION_IMAGE['mobile']['width'], SELF::RESOLUTION_IMAGE['mobile']['height']);
                        break;
                    default:
                        $image = $this->resize($source['source'], SELF::RESOLUTION_IMAGE['pc']['width'], SELF::RESOLUTION_IMAGE['pc']['height']);
                        break;
                }
                $imagesDetail[$key]['device'] = $device;
                $imagesDetail[$key]['name'] = $this->saveImage($image, [
                    'webp', 'jpg'
                ]);

                $this->delete([$source['name']]);
            }
        }

        return $imagesDetail;
    }
}
