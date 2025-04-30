<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class SuratController extends Controller
{
    public function create()
    {
        return view('word');
    }

    private function numberToRoman($number) {
        $romans = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];
        
        $result = '';
        foreach ($romans as $roman => $value) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }
        return $result;
    }

    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        \Log::info('Data form diterima:', $request->all());
        
        try {
            // Validasi jenis surat
            $request->validate([
                'jenis_surat' => 'required|in:domisili,keterangan',
            ]);

            // Cek apakah ini form domisili atau form default
            if ($request->jenis_surat === 'domisili') {
                // Form domisili
                $request->validate([
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|string|size:16',
                    'tempat_lahir' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date',
                    'jeniskelamin' => 'required|in:Laki-laki,Perempuan',
                    'agama' => 'required|string|max:255',
                    'alamat' => 'required|string',
                    'pekerjaan' => 'required|string|max:255',
                ], [
                    'nik.size' => 'NIK harus terdiri dari 16 digit',
                    'jeniskelamin.in' => 'Jenis kelamin harus dipilih',
                    'agama.required' => 'Agama harus dipilih',
                ]);

                // Generate nomor surat
                $tahun = date('Y');
                $bulan = date('n');
                $bulanRomawi = $this->numberToRoman($bulan);
                $count = Surat::whereYear('created_at', $tahun)
                              ->whereMonth('created_at', $bulan)
                              ->count() + 1;
                
                $nomor_surat = "470/".$count."/".$bulanRomawi."/".$tahun;

                // Simpan data surat
                $surat = new Surat();
                $surat->nomor_surat = $nomor_surat;
                $surat->nama = $request->nama;
                $surat->nik = $request->nik;
                $surat->tempat_lahir = $request->tempat_lahir;
                $surat->tanggal_lahir = $request->tanggal_lahir;
                $surat->jeniskelamin = $request->jeniskelamin;
                $surat->agama = $request->agama;
                $surat->alamat = $request->alamat;
                $surat->pekerjaan = $request->pekerjaan;
                $surat->user_id = Auth::id();
                $surat->status = 'pending';
                $surat->jenis_surat = 'domisili';
                $surat->save();
                
                \Log::info('Surat domisili berhasil disimpan dengan ID: ' . $surat->id);
            } else {
                // Form default
                $request->validate([
                    'keperluan' => 'required|string|max:255',
                    'keterangan' => 'nullable|string',
                    'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                ], [
                    'keperluan.required' => 'Keperluan surat harus diisi',
                    'dokumen.mimes' => 'Format file harus PDF, JPG, atau PNG',
                    'dokumen.max' => 'Ukuran file maksimal 2MB',
                ]);
                
                // Generate nomor surat untuk form default
                $tahun = date('Y');
                $bulan = date('n');
                $bulanRomawi = $this->numberToRoman($bulan);
                $count = Surat::whereYear('created_at', $tahun)
                              ->whereMonth('created_at', $bulan)
                              ->count() + 1;
                
                $nomor_surat = "470/".$count."/".$bulanRomawi."/".$tahun;
                
                // Handle file upload
                $dokumenPath = null;
                if ($request->hasFile('dokumen')) {
                    try {
                        $dokumenPath = $request->file('dokumen')->store('dokumen', 'public');
                    } catch (\Exception $e) {
                        \Log::error('Error saat upload file: ' . $e->getMessage());
                        return redirect()->route('user.pengajuansurat')
                            ->with('error', 'Gagal mengupload file. Silakan coba lagi.');
                    }
                }
                
                // Simpan data surat default
                $surat = new Surat();
                $surat->nomor_surat = $nomor_surat;
                $surat->nama = Auth::user()->name;
                $surat->nik = Auth::user()->nik ?? '0000000000000000';
                $surat->tempat_lahir = '-';
                $surat->tanggal_lahir = now();
                $surat->jeniskelamin = '-';
                $surat->agama = '-';
                $surat->alamat = Auth::user()->address ?? '-';
                $surat->pekerjaan = '-';
                $surat->user_id = Auth::id();
                $surat->status = 'pending';
                $surat->jenis_surat = 'keterangan';
                $surat->keperluan = $request->keperluan;
                $surat->keterangan = $request->keterangan;
                $surat->dokumen = $dokumenPath;
                $surat->save();
                
                \Log::info('Surat default berhasil disimpan dengan ID: ' . $surat->id);
            }

            return redirect()->route('user.pengajuansurat')
                ->with('success', 'Pengajuan surat berhasil dibuat! Silakan tunggu persetujuan dari admin.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validasi error: ' . json_encode($e->errors()));
            return redirect()->route('user.pengajuansurat')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan surat: ' . $e->getMessage());
            return redirect()->route('user.pengajuansurat')
                ->with('error', 'Terjadi kesalahan saat mengajukan surat. Silakan coba lagi.');
        }
    }

    public function riwayat()
    {
        $surat = Surat::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('user.riwayatsurat', compact('surat'));
    }

    public function download($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            
            // Cek apakah user yang login adalah pemilik surat
            if ($surat->user_id !== Auth::id()) {
                return redirect()->route('user.riwayatsurat')->with('error', 'Anda tidak memiliki akses ke surat ini!');
            }
            
            // Cek apakah surat sudah disetujui
            if ($surat->status !== 'approved') {
                return redirect()->route('user.riwayatsurat')->with('error', 'Surat belum disetujui oleh admin!');
            }
            
            // Generate surat Word jika belum ada
            $filePath = storage_path('app/public/surat/' . $id . '.docx');
            
            if (!file_exists($filePath)) {
                // Generate surat Word
                $templatePath = public_path('template/surat_keterangan.docx');
                
                if (!file_exists($templatePath)) {
                    \Log::error('Template file not found: ' . $templatePath);
                    return redirect()->route('user.riwayatsurat')->with('error', 'Template surat tidak ditemukan!');
                }
                
                $outputPath = storage_path('app/public/surat/' . $surat->id . '.docx');
                
                try {
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
                    
                    // Replace placeholders
                    $templateProcessor->setValue('nomor_surat', $surat->nomor_surat);
                    $templateProcessor->setValue('nama', $surat->nama);
                    $templateProcessor->setValue('nik', $surat->nik);
                    $templateProcessor->setValue('tempat_lahir', $surat->tempat_lahir);
                    $templateProcessor->setValue('tanggal_lahir', Carbon::parse($surat->tanggal_lahir)->isoFormat('D MMMM Y'));
                    $templateProcessor->setValue('jeniskelamin', $surat->jeniskelamin);
                    $templateProcessor->setValue('agama', $surat->agama);
                    $templateProcessor->setValue('alamat', $surat->alamat);
                    $templateProcessor->setValue('pekerjaan', $surat->pekerjaan);
                    $templateProcessor->setValue('tanggal_surat', Carbon::now()->isoFormat('D MMMM Y'));
                    
                    $templateProcessor->saveAs($outputPath);
                } catch (\Exception $e) {
                    \Log::error('Error generating Word document: ' . $e->getMessage());
                    return redirect()->route('user.riwayatsurat')->with('error', 'Gagal membuat file surat!');
                }
            }
            
            return response()->download($filePath, 'Surat_Keterangan_' . $surat->nomor_surat . '.docx');
        } catch (\Exception $e) {
            \Log::error('Error in download method: ' . $e->getMessage());
            return redirect()->route('user.riwayatsurat')->with('error', 'Terjadi kesalahan saat mengunduh surat!');
        }
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Cek apakah user yang login adalah pemilik surat
        if ($surat->user_id !== Auth::id()) {
            return redirect()->route('user.riwayatsurat')->with('error', 'Anda tidak memiliki akses untuk menghapus surat ini!');
        }
        
        // Hapus file surat jika ada
        $filePath = storage_path('app/public/surat/' . $id . '.docx');
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Hapus data surat
        $surat->delete();
        
        return redirect()->route('user.riwayatsurat')->with('success', 'Pengajuan surat berhasil dihapus!');
    }
} 