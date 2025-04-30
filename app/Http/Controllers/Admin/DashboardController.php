<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSurat = Surat::count();
        $suratPending = Surat::where('status', 'pending')->count();
        $suratApproved = Surat::where('status', 'approved')->count();
        $latestSurat = Surat::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalSurat',
            'suratPending',
            'suratApproved',
            'latestSurat'
        ));
    }
} 