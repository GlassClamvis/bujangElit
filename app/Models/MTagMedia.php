<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MTagMedia extends Model
{
    use HasFactory;
    protected $table = 'tag_media';
    protected $guarded = ['id'];
}
