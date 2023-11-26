<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSubMenu extends Model
{
    use HasFactory;
    protected $table = 'submenu';
    protected $guarded = ['id'];

    public function Menu(){
        return $this->belongsTo(MMenu::class,'menu_id');//table class,fk
    }
}
