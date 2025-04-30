<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeterangan extends Model
{
    use HasFactory;

    protected $table = 'surat_keterangan';

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jeniskelamin',
        'alamat',
        'pekerjaan',
        'agama',
        'nomor_surat',
        'file_path',
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}
}

// app/Models/SuratKeterangan.php


