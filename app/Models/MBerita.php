<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MBerita extends Model
{
    use HasFactory;
    protected $table = 'berita';
    protected $guarded = ['id'];

    public function kategoriData()
    {
        return $this->belongsTo(MKategori::class, 'kategori_id'); //table class,fk
    }

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
