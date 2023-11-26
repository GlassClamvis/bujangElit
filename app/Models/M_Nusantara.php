<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class M_Nusantara extends Model
{
    use HasFactory;
    protected $table = 'nusantara';
    protected $guarded = ['id'];
}
