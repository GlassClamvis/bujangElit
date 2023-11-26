<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMediaData extends Model
{
    use HasFactory;
    protected $table = 'media_data';
    protected $guarded = ['id'];

    public function JenisMediaProperti(){
        return $this->belongsTo(MJenisMediaProperties::class,'jenis_media_properties_id');//table class,fk
    }
    public function media(){
        return $this->belongsTo(MMedia::class,'media_id');//table class,fk
    }
}
