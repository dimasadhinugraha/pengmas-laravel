<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Surat - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/style.css') }}" />
    <style>
        .history-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box .form-control {
            padding-left: 3rem;
            border-radius: 10px;
            border: 2px solid #eee;
            box-shadow: none;
        }

        .search-box .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-dropdown {
            min-width: 200px;
        }

        .status-badge {
            padding: 0.5em 1em;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        .letter-preview {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .letter-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #dee2e6;
        }

        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin: 0 0.25rem;
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
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Riwayat Pengajuan Surat</h1>
                        <p class="text-muted">Kelola dan pantau status pengajuan surat Anda</p>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="history-card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="search-box">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" class="form-control" placeholder="Cari berdasarkan nomor surat, jenis surat..." onkeyup="searchTable(this, 'historyTable')">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex gap-2 justify-content-md-end">
                                <select class="form-select filter-dropdown" id="statusFilter" onchange="filterTable()">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Diproses</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                                <select class="form-select filter-dropdown" id="jenisFilter" onchange="filterTable()">
                                    <option value="">Semua Jenis Surat</option>
                                    <option value="domisili">Surat Keterangan Domisili</option>
                                    <option value="usaha">Surat Keterangan Usaha</option>
                                    <option value="sktm">Surat Keterangan Tidak Mampu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="history-card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="historyTable">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat as $s)
                                <tr>
                                    <td>{{ $s->nomor_surat }}</td>
                                    <td>{{ $s->created_at->format('d M Y') }}</td>
                                    <td>Surat Keterangan Domisili</td>
                                    <td>
                                        @if($s->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-spinner fa-spin"></i> Diproses
                                        </span>
                                        @elseif($s->status == 'approved')
                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                        @else
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if($s->status == 'approved')
                                            <a href="{{ route('download.surat', $s->id) }}" class="btn btn-primary action-btn" data-bs-toggle="tooltip" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                            <button class="btn btn-light action-btn" data-bs-toggle="modal" data-bs-target="#detailModal{{ $s->id }}" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($s->status == 'pending')
                                            <form action="{{ route('delete.surat', $s->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger action-btn" data-bs-toggle="tooltip" title="Batalkan" onclick="showCancelAlert(this)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <p class="mb-0">Belum ada riwayat pengajuan surat</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white border-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
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
                    <div class="letter-preview">
                        <div class="letter-header">
                            <h4>PEMERINTAH DESA CIASMARA</h4>
                            <p class="mb-0">Jl. Raya Ciasmara No. 1, Kec. Pamijahan, Kab. Bogor</p>
                        </div>
                        <div class="mb-4">
                            <p class="mb-1"><strong>Nomor Surat:</strong> {{ $s->nomor_surat }}</p>
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong> {{ $s->created_at->format('d F Y') }}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                @if($s->status == 'pending')
                                <span class="status-badge status-pending">Diproses</span>
                                @elseif($s->status == 'approved')
                                <span class="status-badge status-approved">Disetujui</span>
                                @else
                                <span class="status-badge status-rejected">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-4">
                            <h6>Data Pemohon</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $s->nama }}</p>
                            <p class="mb-1"><strong>NIK:</strong> {{ $s->nik }}</p>
                            <p class="mb-1"><strong>Tempat, Tanggal Lahir:</strong> {{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d F Y') }}</p>
                            <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $s->jeniskelamin }}</p>
                            <p class="mb-1"><strong>Agama:</strong> {{ $s->agama }}</p>
                            <p class="mb-1"><strong>Alamat:</strong> {{ $s->alamat }}</p>
                            <p class="mb-1"><strong>Pekerjaan:</strong> {{ $s->pekerjaan }}</p>
                        </div>
                        @if($s->keterangan)
                        <div>
                            <h6>Keterangan</h6>
                            <p>{{ $s->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    @if($s->status == 'approved')
                    <a href="{{ route('download.surat', $s->id) }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Unduh Surat
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/script.js') }}"></script>
    <script>
        function showDetail(noSurat) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }

        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const jenisFilter = document.getElementById('jenisFilter').value.toLowerCase();
            const searchText = document.querySelector('.search-box input').value.toLowerCase();
            const table = document.getElementById('historyTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let row of rows) {
                const statusCell = row.cells[3].textContent.toLowerCase();
                const jenisCell = row.cells[2].textContent.toLowerCase();
                const nomorCell = row.cells[0].textContent.toLowerCase();
                const tanggalCell = row.cells[1].textContent.toLowerCase();

                // Mapping status filter ke teks yang ditampilkan
                let statusMatch = false;
                if (!statusFilter) {
                    statusMatch = true;
                } else {
                    switch(statusFilter) {
                        case 'pending':
                            statusMatch = statusCell.includes('diproses');
                            break;
                        case 'approved':
                            statusMatch = statusCell.includes('disetujui');
                            break;
                        case 'rejected':
                            statusMatch = statusCell.includes('ditolak');
                            break;
                    }
                }

                const matchesJenis = !jenisFilter || jenisCell.includes(jenisFilter);
                const matchesSearch = !searchText || 
                    nomorCell.includes(searchText) || 
                    tanggalCell.includes(searchText) || 
                    jenisCell.includes(searchText) || 
                    statusCell.includes(searchText);

                if (statusMatch && matchesJenis && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // Tambahkan event listener untuk search box
        document.querySelector('.search-box input').addEventListener('keyup', filterTable);

        // Fungsi untuk menampilkan alert saat surat dibatalkan
        function showCancelAlert(button) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pengajuan surat akan dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

