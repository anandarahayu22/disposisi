<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/surat_masuks
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(SuratMasuk::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/surat_masuks
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diunggah
        $request->validate([
            'nomor_surat' => 'required|unique:surat_masuks',
            'pengirim' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filename = null;

        // Mengunggah file jika ada
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $path = $file->store('public/uploads/surat'); // Menyimpan file ke direktori storage
            $filename = basename($path);
        }

        // Membuat data surat masuk
        $suratMasuk = SuratMasuk::create([
            'nomor_surat' => $request->nomor_surat,
            'pengirim' => $request->pengirim,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'file_surat' => $filename, // Menyimpan nama file (atau null jika tidak ada)
        ]);

        return response()->json($suratMasuk, 201);
    }

    /**
     * Display the specified resource.
     * GET /api/surat_masuks/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suratMasuk = SuratMasuk::find($id);

        if (!$suratMasuk) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // Mendapatkan URL file surat dari storage
        $suratMasuk->file_url = $suratMasuk->file_surat ? Storage::url('public/uploads/surat/' . $suratMasuk->file_surat) : null;

        return response()->json($suratMasuk, 200);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/surat_masuks/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::find($id);

        if (!$suratMasuk) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // Validasi data yang diupdate
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'unique:surat_masuks,nomor_surat,' . $id,
            'pengirim' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Mengunggah file jika ada
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $path = $file->store('public/uploads/surat');
            $filename = basename($path);

            // Hapus file lama jika ada
            if ($suratMasuk->file_surat && Storage::exists('public/uploads/surat/' . $suratMasuk->file_surat)) {
                Storage::delete('public/uploads/surat/' . $suratMasuk->file_surat);
            }

            $suratMasuk->file_surat = $filename;
        }

        // Update data surat masuk
        $suratMasuk->fill($request->except('file_surat'));
        $suratMasuk->save();

        return response()->json([
            'message' => 'Surat berhasil diupdate',
            'data' => $suratMasuk
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     * DELETE /api/surat_masuks/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::find($id);

        if (!$suratMasuk) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        // Menghapus file yang terkait jika ada
        if ($suratMasuk->file_surat && Storage::exists('public/uploads/surat/' . $suratMasuk->file_surat)) {
            Storage::delete('public/uploads/surat/' . $suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        return response()->json(['message' => 'Surat berhasil dihapus'], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $surat = SuratMasuk::find($id);
        if ($surat) {
            $surat->status = $request->input('status', 2); // Default status ke 2 jika tidak ada input
            $surat->save();

            return response()->json([
                'message' => 'Status surat berhasil diperbarui',
                'data' => $surat
            ], 200);
        }

        return response()->json([
            'message' => 'Surat tidak ditemukan'
        ], 404);
    }
}
