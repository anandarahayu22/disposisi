<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisis';

    protected $fillable = [
        'surat_id',
        'pengirim_id',
        'penerima_id',
        'disposisi',
        'keterangan',
        'status',
        'tgl_verifikasi',
        'Read',
    ];
}
