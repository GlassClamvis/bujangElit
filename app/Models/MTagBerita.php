<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MTagBerita extends Model
{
    use HasFactory;
    protected $table = 'tag_berita';
    protected $guarded = ['id'];
}
