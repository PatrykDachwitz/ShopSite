<?php
declare(strict_types=1);
namespace App\Repository\Admin\Eloquent;

use App\Models\Banner;
use App\Models\BannerFileRelation;
use App\Models\File;
use App\Models\Type;
use App\Repository\Admin\BannerRepository as BannerRepositoryInterface;
use Carbon\Carbon;
use function PHPUnit\Framework\isEmpty;

class BannerRepository extends MainFunction implements BannerRepositoryInterface
{

    private $firstRelation;

    public function __construct(Banner $model) {
        $this->model = $model;
    }

    public function getTypes()
    {
        return Type::where('role', 'banner')->get();
    }

    public function lastPosition(string $type) {
        return ($this->model
                ->where('type', $type)
                ->get()
                ->max('position')) + 1;
    }

    public function find(int $id)
    {
        return $this->model->with('type')->with('file')->findOrFail($id);
    }

    public function create(array $data)
    {
        $namefile = uniqid() . '.html';
        $postion = $this->lastPosition($data['type']);
        $newBanner = new $this->model();

        $newBanner->name = $data['name'];
        $newBanner['start-date'] = $data['start-date'];
        $newBanner['end-date'] = $data['end-date'];
        $newBanner->type_id = $data['type'];
        $newBanner->active = $data['active'];
        $newBanner->position = $postion;
        $newBanner->content = $namefile;
        $newBanner->save();

        return $namefile;
    }

    public function addImage(array $image)
    {
        $file = new File();
        $file->device = $image['device'];
        $file->name = $image['name'];
        $file->created_at = Carbon::now();
        $file->updated_at = Carbon::now();
        $file->save();

        return [
            'id' => $file->id,
            'device' => $image['device']
        ];
    }

    private function updateDefaultFile(array $idFiles,int $idBanner) {
        foreach ($idFiles as $key => $idFile) {
            switch ($key) {
                case "pc":
                    $defaultFile = BannerFileRelation::
                        where("banner_id", $idBanner)
                        ->where("default", 1)
                        ->with('filePc')
                        ->get();
                    break;
                case "mobile":
                    $defaultFile = BannerFileRelation::
                        where("banner_id", $idBanner)
                        ->where("default", 1)
                        ->with('fileMobile')
                        ->get();
                    break;
                default:
                    $defaultFile = BannerFileRelation::
                    where("banner_id", $idBanner)
                        ->where("default", 1)
                        ->with('filePc')
                        ->get();
                    break;
            }

            if (count($defaultFile) >= 1) {
                foreach ($defaultFile as $default) {
                    if ($default->file_id === $idFile) {
                        continue;
                    } else {
                        $default->default = false;
                        $default->save();
                    }
                }
            }

            $actualyRelation = BannerFileRelation::
                where('banner_id', $idBanner)
                ->where('file_id', $idFile)
                ->first();

            $actualyRelation->default = true;
            $actualyRelation->save();
        }

    }

    public function firstFileRelation (int $idBanner, string $device) {
        switch ($device) {
            case "pc":
                $defaultFile = BannerFileRelation::
                where("banner_id", $idBanner)
                    ->where("default", 1)
                    ->with('filePc')
                    ->get();
                break;
            case "mobile":
                $defaultFile = BannerFileRelation::
                where("banner_id", $idBanner)
                    ->where("default", 1)
                    ->with('fileMobile')
                    ->get();
                break;
            default:
                $defaultFile = BannerFileRelation::
                where("banner_id", $idBanner)
                    ->where("default", 1)
                    ->with('filePc')
                    ->get();
                break;
        }

        if(count($defaultFile) >= 1) return false;
        else return true;
    }

    public function update(array $data, array $images)
    {
        $idFiles = [
            'pc' => 13//(int) $data['availableFile']['pc']
            ];
        $id = (int) $data['id'];

        $this
            ->updateDefaultFile($idFiles, $id);

        $updateModel = $this->find($id);
        $updateModel
            ->name = $data['name'];
        $updateModel['start-date'] = $data['start-date'];
        $updateModel['end-date'] = $data['end-date'];
        $updateModel->type_id = $data['type'];
        $updateModel->active = $data['active'];
        $updateModel->position = $data['position'];
        foreach ($images as $image) {
            $fileDetal = $this
                ->addImage($image);

            if(empty($this->firstRelation)) {
                $this->firstRelation = $this->firstFileRelation($id, $fileDetal['device']);
            }

            if($this->firstRelation) {
                $updateModel
                    ->file()
                    ->attach($fileDetal['id'], [
                        'default' => true
                    ]);
            } else {
                $updateModel
                    ->file()
                    ->attach($fileDetal['id'], [
                        'default' => false
                    ]);
            }
            $updateModel
                ->save();
        }

    }
}