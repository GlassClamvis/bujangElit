<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MContentMenu extends Model
{
    use HasFactory;
    protected $table = 'content_menu';
    protected $guarded = ['id'];


    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id'); //table class,fk
    }

    public function incrementViewer()
    {
        $this->increment('viewer');
    }
}
