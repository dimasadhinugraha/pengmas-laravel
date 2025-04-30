<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class SuratController extends Controller
{
    public function index()
    {
        $surat = Surat::orderBy('created_at', 'desc')->get();
        return view('admin.penerimaansurat', compact('surat'));
    }

    public function show(Surat $surat)
    {
        return view('admin.surat.show', compact('surat'));
    }

    public function approve(Surat $surat)
    {
        $surat->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Surat berhasil disetujui');
    }

    public function reject(Surat $surat)
    {
        $surat->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Surat berhasil ditolak');
    }

    public function download($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Cek apakah surat sudah disetujui
        if ($surat->status !== 'approved') {
            return redirect()->route('admin.surat.index')->with('error', 'Surat belum disetujui!');
        }
        
        $filePath = storage_path('app/public/surat/' . $id . '.docx');
        
        if (!file_exists($filePath)) {
            return redirect()->route('admin.surat.index')->with('error', 'File surat tidak ditemukan!');
        }
        
        return response()->download($filePath, 'Surat_Keterangan_' . $surat->nomor_surat . '.docx');
    }

    public function print($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Logic untuk mencetak surat
        // ...

        return redirect()->route('admin.surat')->with('success', 'Surat berhasil dicetak!');
    }
} 