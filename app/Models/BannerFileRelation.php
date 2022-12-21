<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;
class BannerFileRelation extends Model
{
    use HasFactory;

    protected $table = 'banner_file';

    public function file() {
        return $this->hasMany(File::class, 'id', 'file_id');
    }

    public function filePC() {
        return $this->hasMany(File::class, 'id', 'file_id')
            ->where('device', 'pc');
    }
    public function fileMobile() {
        return $this->hasMany(File::class, 'id', 'file_id')
            ->where('device', 'Mobile');
    }

}
