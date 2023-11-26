<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MMedia extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $guarded = ['id'];

    public function penerbitData()
    {
        return $this->belongsTo(MPenerbit::class, 'penerbit_id'); //table class,fk
    }

    public function setTahunTerbitAttribute($value)
    {
        $this->attributes['tahun_terbit'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function PengarangData()
    {
        return $this->hasMany(MPengarang::class, 'media_id'); //table class,fk
    }
    
    public function MediaData()
    {
        return $this->hasMany(MMediaData::class, 'media_id'); //table class,fk
    }

    public function getTahunBukuAttribute()
    {
        return Carbon::parse($this->tahun_terbit)->format('Y');
    }

    public function kategori()
    {
        return $this->belongsTo(MKategori::class, 'kategori_id'); //table class,fk
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y');
    }

    public function getTahunTerbitMediaAttribute()
    {
        return Carbon::parse($this->tahun_terbit)->format('F Y');
    }

    public function incrementViewer()
    {
        $this->increment('viewer');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id'); //table class,fk
    }

    public function bookmark()
    {
        return $this->hasMany(MBookmark::class, 'media_id');
    }
}
