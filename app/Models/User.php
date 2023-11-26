<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_aktif',
        'pengguna_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function penggunaData()
    {
        return $this->belongsTo(MPengguna::class, 'pengguna_id'); //table class,fk
    }

    public function mediaBookmark()
    {
        return $this->belongsToMany(MMedia::class, 'bookmark', 'user_id', 'media_id')
            ->withTimestamps(); // If you have timestamps in your pivot table
    }

    public function bookmark()
    {
        return $this->hasMany(MBookmark::class, 'user_id');
    }
}
