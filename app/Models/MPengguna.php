<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MPengguna extends Model
{
    use HasFactory;
    protected $table = 'pengguna';
    protected $guarded = ['id'];

    public function hasPegawai(){
        return $this->belongsTo(MUnitHasPegawai::class,'pengguna_id');//table class,fk
    }
}
