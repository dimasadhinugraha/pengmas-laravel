<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/style.css')  }}" />
    <style>
        .news-carousel {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .carousel-item {
            height: 400px;
        }

        .carousel-item img {
            height: 100%;
            object-fit: cover;
        }

        .carousel-caption {
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            text-align: left;
        }

        .news-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .news-card img {
            height: 200px;
            object-fit: cover;
        }

        .news-card .card-body {
            padding: 1.5rem;
        }

        .news-meta {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .btn-read-more {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-read-more:hover {
            transform: translateX(5px);
        }

        .section-title {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--secondary-color);
            border-radius: 2px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Dashboard</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('user.berita') }}" class="sidebar-link active">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.profile') }}" class="sidebar-link">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.pengajuansurat') }}" class="sidebar-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Pengajuan Surat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.riwayatsurat') }}" class="sidebar-link">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Pengajuan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.faq')  }}" class="sidebar-link">
                        <i class="fas fa-question-circle"></i>
                        <span>FAQ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main p-3">
            <div class="container-fluid">
                <!-- Welcome Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Selamat Datang, <span class="text-primary">{{ Auth::user()->name }}</span></h1>
                        <p class="text-muted">Berikut adalah informasi terbaru dari Desa Ciasmara</p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            <span id="currentDate">Loading...</span>
                        </span>
                    </div>
                </div>

                <!-- News Carousel -->
                <div class="news-carousel">
                    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @forelse($berita->where('status', 'published')->take(3) as $index => $item)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : '../images/desaciasmara.jpg' }}" 
                                         class="d-block w-100" alt="{{ $item->judul }}">
                                    <div class="carousel-caption">
                                        <span class="badge bg-primary mb-2">{{ ucfirst($item->kategori) }}</span>
                                        <h3>{{ $item->judul }}</h3>
                                        <p>{{ Str::limit($item->isi, 100) }}</p>
                                        <a href="#" class="btn btn-light btn-read-more" data-bs-toggle="modal" data-bs-target="#newsModal{{ $item->id }}">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="carousel-item active">
                                    <img src="../images/desaciasmara.jpg" class="d-block w-100" alt="Tidak ada berita">
                                    <div class="carousel-caption">
                                        <h3>Tidak ada berita</h3>
                                        <p>Belum ada berita yang dipublikasikan</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

                <!-- News Grid -->
                <div class="mb-4">
                    <h2 class="section-title">Berita Terbaru</h2>
                    <div class="row g-4">
                        @forelse($berita->where('status', 'published')->skip(3)->take(6) as $item)
                            <div class="col-md-4">
                                <div class="news-card card">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : '../images/desaciasmara.jpg' }}" 
                                         class="card-img-top" alt="{{ $item->judul }}">
                                    <div class="card-body">
                                        <div class="news-meta">
                                            <i class="fas fa-calendar me-1"></i> {{ $item->created_at->format('d F Y') }}
                                        </div>
                                        <h5 class="card-title">{{ $item->judul }}</h5>
                                        <p class="card-text">{{ Str::limit($item->isi, 100) }}</p>
                                        <a href="#" class="btn btn-primary btn-read-more" data-bs-toggle="modal" data-bs-target="#newsModal{{ $item->id }}">
                                            Baca Selengkapnya
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Belum ada berita yang dipublikasikan</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- News Detail Modals -->
                @foreach($berita->where('status', 'published') as $item)
                    <div class="modal fade" id="newsModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $item->judul }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid mb-3" alt="{{ $item->judul }}">
                                    @endif
                                    <div class="news-meta mb-3">
                                        <span class="badge bg-primary">{{ ucfirst($item->kategori) }}</span>
                                        <span class="ms-2">
                                            <i class="fas fa-calendar me-1"></i> {{ $item->created_at->format('d F Y') }}
                                        </span>
                                    </div>
                                    <div class="news-content">
                                        {!! nl2br(e($item->isi)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/script.js') }}"></script>
    <script>
        // Display current date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', options);
    </script>
</body>
</html>
