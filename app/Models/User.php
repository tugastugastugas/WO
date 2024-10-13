<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'level',
        'nis',
        'kelas',
        'jurusan',
        'foto',
        'update_by',
        'update_at',
        'pembimbing',
        'pembimbing_pkl',
        'deleted_at',
    ];



    protected $hidden = [
        'password',
    ];
}
