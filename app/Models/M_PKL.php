<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_PKL extends Model
{
    use HasFactory;

    // Jika Anda tidak menggunakan tabel bernama 'lokasi', Anda bisa menentukan nama tabel di sini
    protected $table = 'quiz';

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'kolom1',
        'kolom2',
    ];

    // Jika Anda ingin mengatur timestamps (created_at dan updated_at)
    public $timestamps = true;
}
