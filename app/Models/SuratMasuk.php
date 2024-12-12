<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SuratMasuk extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'surat_masuks';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'tujuan',
        'perihal',
        'tanggal_surat',
        'tanggal_terima',
        'status',
        'deskripsi',
        'file_surat',
        'disposisi'
    ];



    // Accessor untuk mendapatkan URL file_surat
    public function getFileSuratUrlAttribute()
    {
        // return Storage::url('files/' . $this->file_surat);
        return $this->file_surat ? Storage::url('uploads/surat/' . $this->file_surat) : null;
    }
}
