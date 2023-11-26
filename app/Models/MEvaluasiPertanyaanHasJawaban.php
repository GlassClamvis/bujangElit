<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MEvaluasiPertanyaanHasJawaban extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_pertanyaan_has_jawaban';
    protected $guarded = ['id'];
    public $timestamps = false;


    public function JawabanData()
    {
        return $this->belongsTo(MEvaluasiJawaban::class, 'jawaban_id'); //table class,fk
    }
    
    public function pertanyaanData()
    {
        return $this->belongsTo(MEvaluasiPertanyaan::class, 'pertanyaan_id'); //table class,fk
    }
}
