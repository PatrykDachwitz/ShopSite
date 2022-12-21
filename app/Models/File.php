<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
      'device',
      'name',
      'created_at',
      'updated_at',
    ];

    public function banner() {
        return $this->belongsToMany(Banner::class, 'banner_file')
            ->withPivot('default');
    }
}
