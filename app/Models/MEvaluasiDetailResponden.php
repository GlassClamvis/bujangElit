<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MEvaluasiDetailResponden extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_detail_responden';
    protected $guarded = ['id'];
    public $timestamps = false;


    public function JawabanData()
    {
        return $this->belongsTo(MEvaluasiPertanyaanHasJawaban::class, 'evaluasi_pertanyaan_has_jawaban_id'); //table class,fk
    }
}
