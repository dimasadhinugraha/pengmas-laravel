<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function adminberitadesa()
    {
        return view('admin.beritadesa');
    }

    public function penerimaansurat()
    {
        $surat = \App\Models\Surat::orderBy('created_at', 'desc')->get();
        return view('admin.penerimaansurat', compact('surat'));
    }

    public function pengelolaanakun()
    {
        $users = User::all(); // Ambil semua data user
        return view('admin.pengelolaanakun', compact('users'));
    }

    public function beritauser()
    {
        return view('user.berita');
    }

    public function userfaq()
    {
        return view('user.faq');
    }

    public function userpengajuansurat()
    {
        $surat = \App\Models\Surat::where('user_id', auth()->id())
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('user.pengajuansurat', compact('surat'));
    }

    public function userprofile()
    {
        return view('user.profile');
    }

    public function riwayatsurat()
    {
        return view('user.riwayatsurat');
    }
}
