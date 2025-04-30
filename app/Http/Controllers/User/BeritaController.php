<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('status', 'published')
                        ->latest()
                        ->get();
                        
        return view('user.berita', compact('berita'));
    }
}
