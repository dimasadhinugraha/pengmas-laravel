<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jeniskelamin',
        'agama',
        'alamat',
        'pekerjaan',
        'user_id',
        'status',
        'keterangan',
        'jenis_surat',
        'keperluan',
        'dokumen',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 