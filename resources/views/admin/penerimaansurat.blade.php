<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Penerimaan Surat - Admin SIAP SK Desa Ciasmara</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
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
                    <a href="{{ route('admin.surat') }}" class="sidebar-link active">
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
                        <h1 class="h3 mb-0">Penerimaan Surat</h1>
                        <p class="text-muted">Kelola pengajuan surat dari warga</p>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 bg-light" placeholder="Cari pengajuan..." onkeyup="searchTable(this, 'letterTable')">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" onchange="filterTable(this, 'letterTable')">
                                    <option value="">Semua Jenis Surat</option>
                                    <option value="domisili">Surat Keterangan Domisili</option>
                                    <option value="usaha">Surat Keterangan Usaha</option>
                                    <option value="sktm">Surat Keterangan Tidak Mampu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" onchange="filterTable(this, 'letterTable')">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Letters Table -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="letterTable">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat as $s)
                                <tr>
                                    <td>{{ $s->nomor_surat }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>Surat Keterangan Domisili</td>
                                    <td>{{ $s->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($s->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                        @elseif($s->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                        @else
                                        <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#detailModal{{ $s->id }}" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($s->status == 'pending')
                                            <form action="{{ route('admin.surat.approve', $s->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui" onclick="return confirm('Apakah Anda yakin ingin menyetujui surat ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.surat.reject', $s->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak" onclick="return confirm('Apakah Anda yakin ingin menolak surat ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @elseif($s->status == 'approved')
                                            <a href="{{ route('admin.surat.print', $s->id) }}" class="btn btn-sm btn-primary" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <p class="mb-0">Belum ada pengajuan surat</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    @foreach($surat as $s)
    <div class="modal fade" id="detailModal{{ $s->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Data Pemohon</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $s->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>{{ $s->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ $s->jeniskelamin }}</td>
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td>:</td>
                                    <td>{{ $s->agama }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $s->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>:</td>
                                    <td>{{ $s->pekerjaan }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Detail Surat</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>No. Surat</td>
                                    <td>:</td>
                                    <td>{{ $s->nomor_surat }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td>:</td>
                                    <td>Surat Keterangan Domisili</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pengajuan</td>
                                    <td>:</td>
                                    <td>{{ $s->created_at->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        @if($s->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                        @elseif($s->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                        @else
                                        <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if($s->keterangan)
                    <div class="mb-4">
                        <h6>Keterangan</h6>
                        <p>{{ $s->keterangan }}</p>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    @if($s->status == 'pending')
                    <form action="{{ route('admin.surat.approve', $s->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Setujui
                        </button>
                    </form>
                    <form action="{{ route('admin.surat.reject', $s->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-2"></i>Tolak
                        </button>
                    </form>
                    @elseif($s->status == 'approved')
                    <a href="{{ route('admin.surat.print', $s->id) }}" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>Cetak
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/script.js') }}"></script>
</body>
</html>
