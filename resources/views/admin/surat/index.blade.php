<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengajuan Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Kelola Pengajuan Surat</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($surat->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pengajuan surat</h5>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Surat</th>
                                            <th>Nama</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surat as $index => $s)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $s->nomor_surat }}</td>
                                                <td>{{ $s->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d F Y') }}</td>
                                                <td>
                                                    @if($s->status == 'pending')
                                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                                    @elseif($s->status == 'approved')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($s->status == 'rejected')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.surat.show', $s->id) }}" 
                                                           class="btn btn-sm btn-info" 
                                                           title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        
                                                        @if($s->status == 'approved')
                                                            <a href="{{ route('surat.download', $s->id) }}" 
                                                               class="btn btn-sm btn-success" 
                                                               title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        @endif
                                                        
                                                        @if($s->status == 'pending')
                                                            <a href="{{ route('admin.surat.approve', $s->id) }}" 
                                                               class="btn btn-sm btn-success" 
                                                               title="Setujui"
                                                               onclick="return confirm('Apakah Anda yakin ingin menyetujui surat ini?')">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                            
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#rejectModal{{ $s->id }}"
                                                                    title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>

                                                    <!-- Modal Tolak Surat -->
                                                    <div class="modal fade" id="rejectModal{{ $s->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Tolak Pengajuan Surat</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('admin.surat.reject', $s->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="keterangan" class="form-label">Alasan Penolakan</label>
                                                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 