<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMenu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $guarded = ['id'];

    public function subMenu(){
        return $this->hasMany(MSubMenu::class,'menu_id');
    }
}
