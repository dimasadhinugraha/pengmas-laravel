<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/style.css') }}" />
    <style>
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            color: white;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.2);
            object-fit: cover;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            border-color: white;
        }

        .upload-photo {
            position: relative;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-photo:hover {
            opacity: 0.8;
        }

        .upload-photo input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-weight: 500;
            font-size: 1.1rem;
        }

        .family-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .family-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .family-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 1.5rem;
        }

        .family-card .card-body {
            padding: 1.5rem;
        }

        .family-member {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .family-member:hover {
            background-color: #f8f9fa;
        }

        .family-member:last-child {
            border-bottom: none;
        }

        .member-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }

        .member-info {
            flex: 1;
        }

        .member-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .member-relation {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .btn-add-member {
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }

        .btn-add-member:hover {
            transform: translateX(5px);
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
                <!-- Profile Header -->
                <div class="profile-header text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="Profile" class="profile-avatar" id="profilePreview">
                        <div class="upload-photo position-absolute bottom-0 start-50 translate-middle-x">
                            <button class="btn btn-light btn-sm rounded-pill">
                                <i class="fas fa-camera"></i> Ganti Foto
                            </button>
                            <input type="file" accept="image/*" onchange="previewImage(this, 'profilePreview')">
                        </div>
                    </div>
                    <h4 class="mb-1">Dimas Adhi Nugraha</h4>
                    <p class="mb-0">Warga Desa Ciasmara</p>
                </div>

                <!-- Profile Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h5 class="mb-4">Informasi Pribadi</h5>
                            <div class="mb-3">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">Agustiawan</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Jenis Kelamin</div>
                                <div class="info-value">Laki-laki</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Tempat, Tanggal Lahir</div>
                                <div class="info-value">Bogor, 15 Januari 1990</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Agama</div>
                                <div class="info-value">Islam</div>
                            </div>
                            <button class="btn btn-light mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="fas fa-pencil-alt"></i> Edit Profil
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <h5 class="mb-4">Dokumen Identitas</h5>
                            <div class="mb-3">
                                <div class="info-label">NIK</div>
                                <div class="info-value">3201234567890001</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Nomor KK</div>
                                <div class="info-value">3201234567890002</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Status Pernikahan</div>
                                <div class="info-value">Belum Menikah</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Pekerjaan</div>
                                <div class="info-value">Wiraswasta</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Members -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Anggota Keluarga</h5>
                            <button class="btn btn-primary btn-add-member" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
                                <i class="fas fa-plus"></i> Tambah Anggota
                            </button>
                        </div>
                        <div class="family-member">
                            <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=random" alt="Member" class="member-avatar">
                            <div class="member-info">
                                <div class="member-name">Agustiawati</div>
                                <div class="member-relation">Istri</div>
                            </div>
                            <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                        <div class="family-member">
                            <img src="https://ui-avatars.com/api/?name=John+Jr&background=random" alt="Member" class="member-avatar">
                            <div class="member-info">
                                <div class="member-name">Agustiawan Jr.</div>
                                <div class="member-relation">Anak (1)</div>
                            </div>
                            <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Dimas Adhi Nugraha">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" value="Bogor">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" value="1990-01-15">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="Wiraswasta">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Family Modal -->
    <div class="modal fade" id="addFamilyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota Keluarga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" placeholder="Masukkan NIK">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hubungan</label>
                            <select class="form-select">
                                <option value="">Pilih hubungan</option>
                                <option value="suami">Suami</option>
                                <option value="istri">Istri</option>
                                <option value="anak">Anak</option>
                                <option value="orang_tua">Orang Tua</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Tambah Anggota</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/script.js') }}"></script>
</body>
</html>
