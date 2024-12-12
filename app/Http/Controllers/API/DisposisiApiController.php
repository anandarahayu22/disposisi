<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisposisiApiController extends Controller
{
    public function index()
    {
        $disposisis = Disposisi::all();
        return response()->json($disposisis);
    }

    public function show($id)
    {
        $disposisi = Disposisi::find($id);
        if ($disposisi) {
            return response()->json($disposisi);
        } else {
            return response()->json(['message' => 'Disposisi not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'surat_id' => 'required|string',
            'pengirim_id' => 'required|string',
            'penerima_id' => 'required|string',
            'disposisi' => 'required|string',
            'status' => 'required|string',
            'tgl_verifikasi' => 'required|date',
            'read' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $disposisi = Disposisi::create($request->all());

        $id_surat = intval($request->surat_id);
        $surat_masuks = SuratMasuk::where('id', $id_surat)->first();

        // Periksa apakah surat masuk ditemukan, lalu perbarui kolom disposisi dan status
        if ($surat_masuks) {
            $surat_masuks->disposisi = "fill";
            $surat_masuks->status = 1;
            $surat_masuks->save();
        } else {
            // Jika surat masuk tidak ditemukan, beri tahu dengan pesan
            return response()->json(['message' => 'SuratMasuk not found'], 404);
        }
        return response()->json($disposisi, 201);
    }

    public function update(Request $request, $id)
    {
        $disposisi = Disposisi::find($id);

        if (!$disposisi) {
            return response()->json(['message' => 'Disposisi not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'surat_id' => 'sometimes|string',
            'pengirim_id' => 'sometimes|string',
            'penerima_id' => 'sometimes|string',
            'disposisi' => 'sometimes|string',
            'status' => 'sometimes|string',
            'tgl_verifikasi' => 'sometimes|date',
            'read' => 'nullable|boolean', // Ubah 'Read' menjadi 'read'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $disposisi->update($request->all());
        return response()->json($disposisi);
    }

    public function destroy($id)
    {
        $disposisi = Disposisi::find($id);

        if ($disposisi) {
            // Dapatkan surat yang terkait
            $surat_masuks = SuratMasuk::where('id', $disposisi->surat_id)->first();

            // Jika surat masuk ditemukan, ubah kolom 'disposisi' menjadi null
            if ($surat_masuks) {
                $surat_masuks->disposisi = null;
                $surat_masuks->status = 0;
                $surat_masuks->save();
            }

            // Hapus disposisi
            $disposisi->delete();
            return response()->json(['message' => 'Disposisi deleted successfully']);
        } else {
            return response()->json(['message' => 'Disposisi not found'], 404);
        }
    }
}
