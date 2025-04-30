<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="d-flex">

                <div class="sidebar-logo">
                    <a href="#">Admin Dashboard</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.berita') }}" class="sidebar-link">
                        <i class="fas fa-newspaper"></i>
                        <span>Berita Desa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.surat') }}" class="sidebar-link">
                        <i class="fas fa-envelope"></i>
                        <span>Penerimaan Surat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.akun') }}" class="sidebar-link">
                        <i class="fas fa-users-cog"></i>
                        <span>Pengelolaan Akun</span>
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
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Dashboard</h1>
                        <p class="text-muted">Selamat datang di panel admin Desa Ciasmara</p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            <span id="currentDate">Loading...</span>
                        </span>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Surat Masuk</h6>
                                        <h3 class="mb-0">24</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Surat Disetujui</h6>
                                        <h3 class="mb-0">18</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Menunggu</h6>
                                        <h3 class="mb-0">6</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Total Warga</h6>
                                        <h3 class="mb-0">1,254</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities & Quick Actions -->
                <div class="row g-4">
                    <!-- Recent Activities -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-white border-0">
                                <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="activity-item d-flex p-3 border-bottom">
                                    <div class="activity-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Surat Keterangan Domisili disetujui</h6>
                                        <small class="text-muted">2 menit yang lalu</small>
                                    </div>
                                </div>
                                <div class="activity-item d-flex p-3 border-bottom">
                                    <div class="activity-icon bg-primary">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Pengajuan surat baru diterima</h6>
                                        <small class="text-muted">15 menit yang lalu</small>
                                    </div>
                                </div>
                                <div class="activity-item d-flex p-3 border-bottom">
                                    <div class="activity-icon bg-info">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Pendaftaran warga baru</h6>
                                        <small class="text-muted">1 jam yang lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-white border-0">
                                <h5 class="card-title mb-0">Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary d-flex align-items-center gap-2 justify-content-center">
                                        <i class="fas fa-plus"></i>
                                        Tambah Berita
                                    </button>
                                    <button class="btn btn-success d-flex align-items-center gap-2 justify-content-center">
                                        <i class="fas fa-envelope"></i>
                                        Proses Surat
                                    </button>
                                    <button class="btn btn-info d-flex align-items-center gap-2 justify-content-center text-white">
                                        <i class="fas fa-user-plus"></i>
                                        Tambah Akun
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/script.js') }}"></script>
    <script>
        // Display current date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', options);
    </script>
</body>
</html>
