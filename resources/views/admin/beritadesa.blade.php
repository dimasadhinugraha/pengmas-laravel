<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Berita Desa - Admin SIAP SK Desa Ciasmara</title>
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
                    <a href="{{ route('admin.berita.index') }}" class="sidebar-link active">
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
                        <h1 class="h3 mb-0">Berita Desa</h1>
                        <p class="text-muted">Kelola berita dan informasi desa</p>
                    </div>
                    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addNewsModal">
                        <i class="fas fa-plus"></i>
                        Tambah Berita
                    </button>
                </div>

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 bg-light" placeholder="Cari berita..." onkeyup="searchTable(this, 'newsTable')">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" onchange="filterTable(this, 'newsTable')">
                                    <option value="">Semua Kategori</option>
                                    <option value="pembangunan">Pembangunan</option>
                                    <option value="kegiatan">Kegiatan</option>
                                    <option value="pengumuman">Pengumuman</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Table -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="newsTable">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($berita as $item)
                                    <tr>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->status == 'published' ? 'success' : 'warning' }}">
                                                {{ $item->status == 'published' ? 'Dipublikasi' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editNewsModal{{ $item->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada berita</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add News Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Pilih kategori</option>
                                <option value="pembangunan">Pembangunan</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="pengumuman">Pengumuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Utama</label>
                            <input type="file" class="form-control" name="gambar" accept="image/*">
                            <img src="" class="image-preview mt-2 d-none" style="max-width: 200px">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Berita</label>
                            <textarea class="form-control" name="isi" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="publishNow" id="publishNow">
                                <label class="form-check-label" for="publishNow">Publikasikan sekarang</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit News Modal -->
    @foreach($berita as $item)
    <div class="modal fade" id="editNewsModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" name="judul" value="{{ $item->judul }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Pilih kategori</option>
                                <option value="pembangunan" {{ $item->kategori == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="kegiatan" {{ $item->kategori == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="pengumuman" {{ $item->kategori == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Utama</label>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-thumbnail mb-2" style="max-width: 200px">
                            @endif
                            <input type="file" class="form-control" name="gambar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Berita</label>
                            <textarea class="form-control" name="isi" rows="5" required>{{ $item->isi }}</textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="publishNow" id="publishNow{{ $item->id }}" {{ $item->status == 'published' ? 'checked' : '' }}>
                                <label class="form-check-label" for="publishNow{{ $item->id }}">Publikasikan sekarang</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/script.js') }}"></script>
</body>
</html>
