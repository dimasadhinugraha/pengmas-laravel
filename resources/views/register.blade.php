<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIAP SK Desa Ciasmara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 76px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: rgba(255,255,255,0.95) !important;
        }
        .register-container {
            flex: 1;
            padding: 2rem 0;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
        }
        .input-group-text {
            background: transparent;
            border-right: none;
            min-width: 45px;
            justify-content: center;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus + .input-group-text {
            border-color: #86b7fe;
        }
        .form-text {
            font-size: 0.875em;
            color: #6c757d;
        }
        @media (max-width: 991px) {
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                border-radius: 0 0 1rem 1rem;
                z-index: 1000;
            }
            .navbar-nav {
                padding: 0.5rem;
            }
            .navbar-nav .nav-item {
                margin: 0.5rem 0;
                text-align: center;
            }
            .navbar-nav .btn {
                margin-top: 0.5rem;
            }
            .register-card {
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.html">SIAP SK</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}#feature">Feature</a></li>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4 w-100" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Register Form -->
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="register-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Daftar Akun</h2>
                            <p class="text-muted">Silakan lengkapi data diri Anda</p>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Gagal mendaftar!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('register.success') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            <!-- NIK -->
                            @csrf
                            <div class="mb-4">
                                <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-id-card text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="nik" name="nik"
                                        placeholder="Masukkan NIK" required
                                        pattern="[0-9]{16}" maxlength="16">
                                    <div class="invalid-feedback">
                                        NIK harus 16 digit angka
                                    </div>
                                </div>
                                <div class="form-text">16 digit nomor yang tertera pada KTP</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" id="email" name="email"
                                        placeholder="Masukkan email" required>
                                    <div class="invalid-feedback">
                                        Masukkan alamat email yang valid
                                    </div>
                                </div>
                                <div class="form-text">Contoh: nama@email.com</div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="fullName" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="fullName" name="name"
                                        placeholder="Masukkan nama lengkap" required>
                                    <div class="invalid-feedback">
                                        Nama lengkap harus diisi
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <label for="address" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-home text-muted"></i>
                                    </span>
                                    <textarea class="form-control border-start-0" id="address" name="address"
                                        placeholder="Masukkan alamat lengkap" required rows="3"></textarea>
                                    <div class="invalid-feedback">
                                        Alamat harus diisi
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor HP -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">Nomor Handphone</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-phone text-muted"></i>
                                    </span>
                                    <input type="tel" class="form-control border-start-0" id="phone" name="phone"
                                        placeholder="Masukkan nomor HP" required
                                        pattern="[0-9]{10,13}">
                                    <div class="invalid-feedback">
                                        Nomor HP harus 10-13 digit angka
                                    </div>
                                </div>
                                <div class="form-text">Contoh: 08123456789</div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0" id="password" name="password"
                                        placeholder="Masukkan password" required minlength="8">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Password minimal 8 karakter
                                    </div>
                                </div>
                                <div class="form-text">Minimal 8 karakter</div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0" id="password_confirmation"
                                        name="password_confirmation" placeholder="Konfirmasi password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Password tidak cocok
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen Pendukung -->
                            <div class="mb-4">
                                <label class="form-label">Dokumen Pendukung</label>

                                <!-- KTP -->
                                <div class="mb-3">
                                    <label for="ktp" class="form-label text-muted small">Foto KTP</label>
                                    <input type="file" class="form-control" id="ktp" name="ktp"
                                        accept="image/*,.pdf" required>
                                    <div class="invalid-feedback">
                                        Upload foto KTP (format: jpg, png, atau pdf)
                                    </div>
                                </div>

                                <!-- KK -->
                                <div class="mb-3">
                                    <label for="kk" class="form-label text-muted small">Foto Kartu Keluarga</label>
                                    <input type="file" class="form-control" id="kk" name="kk"
                                        accept="image/*,.pdf" required>
                                    <div class="invalid-feedback">
                                        Upload foto Kartu Keluarga (format: jpg, png, atau pdf)
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fw-semibold">
                                Daftar
                            </button>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Sudah punya akun?
                                    <a href="login.html" class="text-decoration-none">Login disini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 SIAP SK Desa Ciasmara. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    // Check if passwords match
                    const password = form.querySelector('#password');
                    const confirmation = form.querySelector('#password_confirmation');
                    if (password.value !== confirmation.value) {
                        confirmation.setCustomValidity('Passwords do not match');
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        confirmation.setCustomValidity('');
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navbarToggler = document.querySelector('.navbar-toggler');

            if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
                if (navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                }
            }
        });

        // Input validation
        document.getElementById('nik').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
        });

        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);
        });

        // Password validation
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password');
            if (this.value !== password.value) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
