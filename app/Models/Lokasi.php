<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    // Jika Anda tidak menggunakan tabel bernama 'lokasi', Anda bisa menentukan nama tabel di sini
    protected $table = 'lokasi';

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'latitude',
        'longitude',
        'address',
        'id_user'
    ];

    // Jika Anda ingin mengatur timestamps (created_at dan updated_at)
    public $timestamps = true;
}
