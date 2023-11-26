<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisMediaProperties extends Model
{
    use HasFactory;
    protected $table = 'jenis_media_properties';
    protected $guarded = ['id'];

    public function JenisMedia(){
        return $this->belongsTo(MJenisMedia::class,'jenis_media_id');//table class,fk
    }
}
