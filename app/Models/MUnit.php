<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MUnit extends Model
{
    use HasFactory;
    protected $table                = 'unit';
    protected $guarded              = ['id'];

    public function UnitHasPegawaiData(){
        return $this->hasMany(MUnitHasPegawai::class,'unit_id');
    }
}
