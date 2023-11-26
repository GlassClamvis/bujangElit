<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MEvaluasiPertanyaan extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_pertanyaan';
    protected $guarded = ['id'];
    public $timestamps = false;


    public function hasJawabanData()
    {
        return $this->hasMany(MEvaluasiPertanyaanHasJawaban::class, 'pertanyaan_id'); //table class,fk
    }
}
