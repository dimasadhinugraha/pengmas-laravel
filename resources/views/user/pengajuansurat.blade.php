<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Surat - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/style.css') }}" />
    <style>
        .steps-container {
            position: relative;
            padding: 2rem 0;
        }

        .step-item {
            position: relative;
            padding: 1rem;
            padding-left: 3rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }

        .step-item:hover {
            background-color: #e9ecef;
            transform: translateX(5px);
        }

        .step-number {
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .table-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .status-badge {
            padding: 0.5em 1em;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
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
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 1rem;
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: var(--secondary-color);
            background-color: rgba(59, 125, 221, 0.05);
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
                        <h1 class="h3 mb-0">Pengajuan Surat</h1>
                        <p class="text-muted">Kelola pengajuan surat keterangan Anda</p>
                    </div>
                    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#pengajuanModal">
                        <i class="fas fa-plus"></i>
                        Ajukan Surat
                    </button>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Steps -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Langkah-langkah Pengajuan</h5>
                        <div class="steps-container">
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <h6 class="mb-1">Isi Formulir</h6>
                                <p class="text-muted mb-0">Lengkapi formulir pengajuan dengan data yang valid</p>
                            </div>
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <h6 class="mb-1">Upload Dokumen</h6>
                                <p class="text-muted mb-0">Unggah dokumen pendukung yang diperlukan</p>
                            </div>
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <h6 class="mb-1">Verifikasi</h6>
                                <p class="text-muted mb-0">Tunggu proses verifikasi dari petugas</p>
                            </div>
                            <div class="step-item">
                                <div class="step-number">4</div>
                                <h6 class="mb-1">Selesai</h6>
                                <p class="text-muted mb-0">Surat dapat diambil setelah disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Daftar Pengajuan</h5>
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 bg-light" placeholder="Cari pengajuan..." onkeyup="searchTable(this, 'pengajuanTable')">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table-container">
                            <table class="table table-hover mb-0" id="pengajuanTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Surat</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($surat as $index => $s)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
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
                                                <i class="fas fa-times-circle"></i> Ditolak
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($s->status == 'approved')
                                                <a href="{{ route('download.surat', $s->id) }}" class="btn btn-sm btn-primary action-btn" data-bs-toggle="tooltip" title="Unduh">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @endif
                                                <button class="btn btn-sm btn-light action-btn" data-bs-toggle="modal" data-bs-target="#detailModal{{ $s->id }}" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($s->status == 'pending')
                                                <form action="{{ route('delete.surat', $s->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger action-btn" data-bs-toggle="tooltip" title="Batalkan" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                                                        <i class="fas fa-trash"></i>
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
    </div>

    <!-- Modal Pengajuan -->
    <div class="modal fade" id="pengajuanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="jenisSurat" onchange="toggleForms(this.value)" required>
                                    <option value="">Pilih jenis surat</option>
                                    <option value="domisili">Surat Keterangan Domisili</option>
                                    <option value="usaha">Surat Keterangan Usaha</option>
                                    <option value="tidakmampu">Surat Keterangan Tidak Mampu</option>
                                </select>
                                <label for="jenisSurat">Jenis Surat</label>
                            </div>
                        </div>
                    </div>

                    <!-- Default Form -->
                    <form id="defaultForm" action="{{ route('create.surat') }}" method="POST" class="needs-validation mt-3" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat" value="keterangan">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Keperluan" required>
                                    <label for="keperluan">Keperluan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="keterangan" name="keterangan" style="height: 100px" placeholder="Keterangan tambahan"></textarea>
                                    <label for="keterangan">Keterangan Tambahan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dokumen Pendukung</label>
                                <div class="upload-area" onclick="document.getElementById('fileUpload').click()">
                                    <i class="fas fa-upload fs-2 mb-2"></i>
                                    <p class="mb-0">Klik atau seret file ke sini</p>
                                    <small class="text-muted">Format: PDF, JPG, PNG (Max. 2MB)</small>
                                    <input type="file" id="fileUpload" name="dokumen" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div id="fileInfo" class="mt-2" style="display: none;">
                                    <small class="text-muted">File terpilih: <span id="fileName"></span></small>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Surat Keterangan Domisili Form -->
                    <form id="domisiliForm" action="{{ route('create.surat') }}" method="POST" class="needs-validation mt-3" style="display: none;">
                        @csrf
                        <input type="hidden" name="jenis_surat" value="domisili">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                                    <label for="nama">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required>
                                    <label for="nik">NIK</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" required>
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-control" id="jeniskelamin" name="jeniskelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="jeniskelamin">Jenis Kelamin</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" required>
                                    <label for="pekerjaan">Pekerjaan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="agama" name="agama" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                    <label for="agama">Agama</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" onclick="submitForm(event)">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Surat -->
    @foreach($surat as $s)
    <div class="modal fade" id="detailModal{{ $s->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Surat</label>
                                <p class="mb-0">{{ $s->nomor_surat }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama</label>
                                <p class="mb-0">{{ $s->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <p class="mb-0">{{ $s->nik }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tempat, Tanggal Lahir</label>
                                <p class="mb-0">{{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d F Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <p class="mb-0">{{ $s->jeniskelamin }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Agama</label>
                                <p class="mb-0">{{ $s->agama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <p class="mb-0">{{ $s->alamat }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pekerjaan</label>
                                <p class="mb-0">{{ $s->pekerjaan }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="mb-0">
                                    @if($s->status == 'pending')
                                    <span class="badge bg-warning">Diproses</span>
                                    @elseif($s->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                    @else
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pengajuan</label>
                                <p class="mb-0">{{ $s->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @if($s->keterangan)
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Keterangan</label>
                            <p class="mb-0">{{ $s->keterangan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        function toggleForms(value) {
            const defaultForm = document.getElementById('defaultForm');
            const domisiliForm = document.getElementById('domisiliForm');
            
            if (value === 'domisili') {
                defaultForm.style.display = 'none';
                domisiliForm.style.display = 'block';
            } else {
                defaultForm.style.display = 'block';
                domisiliForm.style.display = 'none';
            }
        }

        // Handle file upload display
        document.getElementById('fileUpload').addEventListener('change', function(e) {
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileInfo.style.display = 'block';
            } else {
                fileInfo.style.display = 'none';
            }
        });

        function submitForm(event) {
            event.preventDefault();
            const selectedValue = document.getElementById('jenisSurat').value;
            
            if (!selectedValue) {
                alert('Silakan pilih jenis surat terlebih dahulu');
                return;
            }
            
            if (selectedValue === 'domisili') {
                // Validasi form domisili
                const domisiliForm = document.getElementById('domisiliForm');
                if (domisiliForm.checkValidity()) {
                    domisiliForm.submit();
                } else {
                    alert('Mohon lengkapi semua field yang diperlukan');
                    domisiliForm.reportValidity();
                }
            } else {
                // Validasi form default
                const defaultForm = document.getElementById('defaultForm');
                if (defaultForm.checkValidity()) {
                    // Validasi ukuran file
                    const fileInput = document.getElementById('fileUpload');
                    if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (file.size > maxSize) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB');
                            return;
                        }
                    }
                    
                    defaultForm.submit();
                } else {
                    alert('Mohon lengkapi semua field yang diperlukan');
                    defaultForm.reportValidity();
                }
            }
        }
    </script>
</body>
</html>
