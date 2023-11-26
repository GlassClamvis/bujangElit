<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MEvaluasiResponden extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_responden';
    protected $guarded = ['id'];
    public $timestamps = false;

}
