<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MJenisMedia extends Model
{
    use HasFactory;
    protected $table = 'jenis_media';
    protected $guarded = ['id'];

    public function properti(){
        return $this->hasMany(MJenisMediaProperties::class,'jenis_media_id');
    }
}
