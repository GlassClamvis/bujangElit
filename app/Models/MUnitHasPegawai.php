<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MUnitHasPegawai extends Model
{
    use HasFactory;
    protected $table = 'unit_has_pengguna';
    protected $guarded = ['id'];

    public function UnitData(){
        return $this->belongsTo(MUnit::class,'unit_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(MPengguna::class,'pengguna_id');//table class,fk
    }
}
