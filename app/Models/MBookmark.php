<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MBookmark extends Model
{
    use HasFactory;
    protected $table = 'bookmark';
    protected $guarded = ['id'];

    public function media()
    {
        return $this->belongsTo(MMedia::class, 'media_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y');
    }
}
