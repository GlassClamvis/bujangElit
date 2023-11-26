<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MEvaluasiJawaban extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_jawaban';
    protected $guarded = ['id'];
    public $timestamps = false;

}
