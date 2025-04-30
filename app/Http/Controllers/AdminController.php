<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSurat = Surat::count();
        $suratPending = Surat::where('status', 'pending')->count();
        $suratApproved = Surat::where('status', 'approved')->count();
        $suratRejected = Surat::where('status', 'rejected')->count();

        return view('admin.dashboard', compact('totalSurat', 'suratPending', 'suratApproved', 'suratRejected'));
    }

    public function surat()
    {
        $surat = Surat::with('user')->latest()->get();
        return view('admin.surat.index', compact('surat'));
    }

    public function showSurat($id)
    {
        $surat = Surat::with('user')->findOrFail($id);
        return view('admin.surat.show', compact('surat'));
    }

    public function approveSurat(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->update([
            'status' => 'approved',
            'keterangan_admin' => $request->keterangan_admin
        ]);

        return redirect()->route('admin.surat')->with('success', 'Surat berhasil disetujui');
    }

    public function rejectSurat(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->update([
            'status' => 'rejected',
            'keterangan_admin' => $request->keterangan_admin
        ]);

        return redirect()->route('admin.surat')->with('success', 'Surat berhasil ditolak');
    }
} 