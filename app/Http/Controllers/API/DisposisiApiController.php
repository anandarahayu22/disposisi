<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DisposisiApiController extends Controller
{
    public function show($suratId)
    {
        $surat = SuratMasuk::find($suratId);
        dd($suratId, $surat);
    }
}
