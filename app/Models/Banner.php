<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "start-date",
        "end-date",
        "type_id",
        "active",
        'content'
    ];

    public function type(){
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function file() {
        return $this->belongsToMany(File::class, 'banner_file')
            ->withPivot('default');
    }
}
