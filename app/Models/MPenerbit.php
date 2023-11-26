<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MPenerbit extends Model
{
    use HasFactory;
    protected $table = 'penerbit';
    protected $guarded = ['id'];
}
