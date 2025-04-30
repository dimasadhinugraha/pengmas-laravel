@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Surat</h5>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nomor Surat</div>
                        <div class="col-md-8">{{ $surat->nomor_surat }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Pemohon</div>
                        <div class="col-md-8">{{ $surat->user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jenis Surat</div>
                        <div class="col-md-8">{{ $surat->jenis_surat }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status</div>
                        <div class="col-md-8">
                            @if($surat->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($surat->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Pengajuan</div>
                        <div class="col-md-8">{{ $surat->created_at->format('d F Y H:i') }}</div>
                    </div>

                    @if($surat->status == 'approved')
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Disetujui</div>
                        <div class="col-md-8">{{ $surat->approved_at->format('d F Y H:i') }}</div>
                    </div>
                    @endif

                    @if($surat->status == 'rejected')
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Ditolak</div>
                        <div class="col-md-8">{{ $surat->rejected_at->format('d F Y H:i') }}</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keperluan</div>
                        <div class="col-md-8">{{ $surat->keperluan }}</div>
                    </div>

                    @if($surat->keterangan)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keterangan</div>
                        <div class="col-md-8">{{ $surat->keterangan }}</div>
                    </div>
                    @endif

                    @if($surat->dokumen)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Dokumen</div>
                        <div class="col-md-8">
                            <a href="{{ asset('storage/' . $surat->dokumen) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download Dokumen
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($surat->status == 'pending')
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <form action="{{ route('admin.surat.approve', $surat) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Setujui Surat
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.surat.reject', $surat) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times"></i> Tolak Surat
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 