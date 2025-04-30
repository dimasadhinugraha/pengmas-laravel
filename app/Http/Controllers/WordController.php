<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use App\Models\SuratKeterangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WordController extends Controller
{
    public function index()
    {
        return view('word');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $data = $request->validate([
                'nama' => 'required',
                'nik' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'jeniskelamin' => 'required',
                'alamat' => 'required',
                'pekerjaan' => 'required',
                'agama' => 'required',
            ]);

            // Format tanggal ke format Indonesia
            $tanggal = Carbon::parse($data['tanggal_lahir'])->locale('id');
            $data['tanggal_lahir'] = $tanggal->isoFormat('D MMMM Y');

            // Hitung jumlah surat bulan ini untuk nomor urut
            $countThisMonth = SuratKeterangan::whereMonth('created_at', now()->month)
                                           ->whereYear('created_at', now()->year)
                                           ->count() + 1;
            $urutanSurat = str_pad($countThisMonth, 3, '0', STR_PAD_LEFT); // ex: 001

            // Konversi bulan ke romawi
            $bulanRomawi = [
                1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
                5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
                9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
            ];
            $bulan = $bulanRomawi[now()->month];
            $tahun = now()->year;

            // Format nomor surat
            $nomorSuratLengkap = "400.12.2.1/{$urutanSurat}/{$bulan}/{$tahun}";

            // Nama file
            $namaFile = 'SKD_' . Str::slug($data['nama']) . '_' . now()->format('Ymd_His') . '.docx';

            // Pastikan direktori storage ada
            $storagePath = storage_path('app/public/surat');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Load template dan isi data
            $template = new TemplateProcessor(public_path('template/SURATKETERANGANDOMISILI.docx'));
            
            // Set semua nilai ke template
            foreach ($data as $key => $value) {
                $template->setValue($key, $value);
            }

            // Set nomor surat dan komponennya
            $template->setValue('nomor_urut', $urutanSurat);
            $template->setValue('bulan_romawi', $bulan);
            $template->setValue('tahun', $tahun);
            $template->setValue('nomor_surat_lengkap', $nomorSuratLengkap);

            // Simpan file
            $filePath = storage_path('app/public/surat/' . $namaFile);
            $template->saveAs($filePath);

            // Verifikasi file tersimpan
            if (!file_exists($filePath)) {
                throw new \Exception('File gagal disimpan');
            }

            // Simpan ke database
            SuratKeterangan::create([
                'user_id' => Auth::id(),
                'nama' => $data['nama'],
                'nik' => $data['nik'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jeniskelamin' => $data['jeniskelamin'],
                'alamat' => $data['alamat'],
                'pekerjaan' => $data['pekerjaan'],
                'agama' => $data['agama'],
                'nomor_surat' => $nomorSuratLengkap,
                'file_path' => 'surat/' . $namaFile,
            ]);

            return back()->with('success', 'Surat berhasil dibuat dan disimpan!');

        } catch (\Exception $e) {
            Log::error('Error in WordController@store: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat surat: ' . $e->getMessage())->withInput();
        }
    }
}
