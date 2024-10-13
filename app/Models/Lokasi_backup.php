<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi_backup extends Model
{
    use HasFactory;

    // Jika Anda tidak menggunakan tabel bernama 'lokasi', Anda bisa menentukan nama tabel di sini
    protected $table = 'lokasi_backup';

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'latitude',
        'longitude',
        'address',
        'id_user',
        'created_at',
        'updated_at',
    ];

    // Jika Anda ingin mengatur timestamps (created_at dan updated_at)
    public $timestamps = true;
}
