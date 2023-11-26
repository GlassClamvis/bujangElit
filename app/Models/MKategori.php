<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\FuncCall;

class MKategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $guarded = ['id'];

    public function berita()
    {
        return $this->hasMany(MBerita::class, 'kategori_id');
    }

    public function jurnal()
    {
        return $this->hasMany(MMedia::class, 'kategori_id')->where('is_aktif', 1)->where('jenis_media_id', 2);
    }

    public function buku()
    {
        return $this->hasMany(MMedia::class, 'kategori_id')->where('is_aktif', 1)->where('jenis_media_id', 1);
    }

    public function media()
    {
        return $this->hasMany(MMedia::class, 'kategori_id')->where('is_aktif', 1);
    }
}
