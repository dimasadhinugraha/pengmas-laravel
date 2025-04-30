<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FAQ - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/style.css') }}" />
    <style>
        .faq-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 3rem 0;
            color: white;
            margin-bottom: 2rem;
            border-radius: 15px;
        }

        .search-box {
            max-width: 600px;
            margin: 2rem auto 0;
            position: relative;
        }

        .search-box .form-control {
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 30px;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .search-box .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .faq-category {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .faq-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(59, 125, 221, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .category-icon i {
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .accordion-item {
            border: none;
            background: white;
            border-radius: 10px !important;
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .accordion-button {
            padding: 1.25rem;
            font-weight: 500;
            background: white;
            border: none;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(59, 125, 221, 0.1);
            color: var(--secondary-color);
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(59, 125, 221, 0.1);
        }

        .step-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .step-list li {
            position: relative;
            padding: 1rem 0 1rem 3rem;
            border-left: 2px solid #dee2e6;
            margin-left: 1rem;
        }

        .step-list li:before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            background-color: var(--secondary-color);
            border-radius: 50%;
        }

        .step-list li:last-child {
            border-left: none;
        }

        .contact-card {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .contact-icon i {
            font-size: 1.5rem;
            color: white;
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
                <!-- FAQ Header -->
                <div class="faq-header text-center">
                    <h1 class="mb-2">Pusat Bantuan</h1>
                    <p class="mb-0">Temukan jawaban untuk pertanyaan umum tentang layanan kami</p>
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Cari pertanyaan..." onkeyup="searchFAQ(this)">
                    </div>
                </div>

                <!-- FAQ Categories -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="faq-category text-center">
                            <div class="category-icon mx-auto">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5>Pengajuan Surat</h5>
                            <p class="text-muted mb-0">Informasi tentang proses pengajuan surat</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="faq-category text-center">
                            <div class="category-icon mx-auto">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5>Anggota Keluarga</h5>
                            <p class="text-muted mb-0">Panduan pengelolaan data keluarga</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="faq-category text-center">
                            <div class="category-icon mx-auto">
                                <i class="fas fa-history"></i>
                            </div>
                            <h5>Riwayat & Status</h5>
                            <p class="text-muted mb-0">Informasi status dan riwayat pengajuan</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion -->
                <div class="accordion" id="faqAccordion">
                    <h5 class="mb-3">Pertanyaan Umum</h5>

                    <!-- Pengajuan Surat -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara mengajukan surat keterangan?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul class="step-list">
                                    <li>Masuk ke menu <strong>Pengajuan Surat</strong></li>
                                    <li>Pilih jenis surat yang ingin diajukan</li>
                                    <li>Isi formulir dengan data yang valid</li>
                                    <li>Upload dokumen pendukung jika diperlukan</li>
                                    <li>Klik tombol "Ajukan" untuk mengirim pengajuan</li>
                                    <li>Tunggu notifikasi status pengajuan Anda</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota Keluarga -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Bagaimana cara menambahkan anggota keluarga?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul class="step-list">
                                    <li>Buka halaman <strong>Profile</strong></li>
                                    <li>Scroll ke bagian Anggota Keluarga</li>
                                    <li>Klik tombol "Tambah Anggota"</li>
                                    <li>Isi data anggota keluarga dengan lengkap</li>
                                    <li>Klik "Simpan" untuk menyelesaikan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pengajuan -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Bagaimana cara melihat status pengajuan surat?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul class="step-list">
                                    <li>Buka menu <strong>Riwayat Pengajuan</strong></li>
                                    <li>Cari pengajuan yang ingin dilihat</li>
                                    <li>Status akan ditampilkan dengan badge warna</li>
                                    <li>Klik "Lihat Detail" untuk informasi lengkap</li>
                                    <li>Unduh surat jika status sudah disetujui</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="contact-card text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>Masih Butuh Bantuan?</h5>
                    <p class="mb-4">Hubungi kami melalui kontak berikut:</p>
                    <div class="row justify-content-center g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-phone me-2"></i>
                                <span>(021) 123-4567</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-envelope me-2"></i>
                                <span>info@ciasmara.desa.id</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fab fa-whatsapp me-2"></i>
                                <span>+62 812-3456-7890</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/script.js') }}"></script>
    <script>
        function searchFAQ(input) {
            const filter = input.value.toLowerCase();
            const items = document.querySelectorAll('.accordion-item');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
