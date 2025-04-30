@extends('layouts.app')

@section('title', 'SIAP SK - Beranda')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-section d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="display-3 fw-bold mb-4">SIAP SK</h1>
            <p class="fs-4 mb-5">Sistem Informasi Permohonan Surat Keterangan Desa Ciasmara</p>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">Desa Ciasmara</h2>
                    <p class="text-muted">Desa Ciasmara adalah sebuah desa yang terletak di wilayah Kecamatan Pamijahan, Kabupaten Bogor, di wilayah Jawa Barat. Lokasi desa ini berada pada koordinat geografis yang berkisar di angka 6.627° LS dan 106.896° BT.</p>
                    <p class="text-muted">Penduduk desa Ciasmara terdiri dari berbagai kelompok masyarakat, dengan sebagian besar dari mereka bermata pencaharian sebagai petani, pedagang, serta pekerja dari sektor lainnya.</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/desaciasmara.jpg') }}" alt="Desa Ciasmara" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="feature" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">Feature</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('images/desaciasmara.jpg') }}" class="card-img-top" alt="Pendaftaran">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Pendaftaran Permohonan</h5>
                            <p class="card-text text-muted">Pendaftaran Permohonan Surat Keterangan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('images/desaciasmara.jpg') }}" class="card-img-top" alt="Status">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Status Permohonan</h5>
                            <p class="card-text text-muted">Lihat Status Permohonan yang telah diajukan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('images/desaciasmara.jpg') }}" class="card-img-top" alt="Berita">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Berita</h5>
                            <p class="card-text text-muted">Berbagai Informasi Terbaru tentang Desa Ciasmara</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
