<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rumah Sakit Sehat Sentosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23f8f9fa" width="1200" height="600"/><path fill="%23e9ecef" d="M0,300 Q300,200 600,300 T1200,300 L1200,600 L0,600 Z"/></svg>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(102, 126, 234, 0.95); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital me-2"></i>
                RS Sehat Sentosa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ms-2 px-3" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-white">
                        <h1 class="display-4 fw-bold mb-4">
                            Rumah Sakit Sehat Sentosa
                        </h1>
                        <p class="lead mb-4">
                            Memberikan pelayanan kesehatan terbaik dengan teknologi modern dan tim medis profesional untuk kesehatan keluarga Anda.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i>Buat Janji Temu
                            </a>
                            <a href="#about" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-hospital fa-10x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">Tentang Kami</h2>
                    <p class="lead text-muted mb-5">
                        Rumah Sakit Sehat Sentosa telah melayani masyarakat selama lebih dari 20 tahun dengan komitmen memberikan pelayanan kesehatan berkualitas tinggi.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold">Pelayanan 24/7</h5>
                        <p class="text-muted">Siap melayani Anda kapan saja dengan tim medis yang berpengalaman.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-user-md fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold">Dokter Spesialis</h5>
                        <p class="text-muted">Tim dokter spesialis terbaik di berbagai bidang kedokteran.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-microscope fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold">Teknologi Modern</h5>
                        <p class="text-muted">Peralatan medis terbaru untuk diagnosis dan pengobatan yang akurat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">Layanan Kami</h2>
                    <p class="lead text-muted mb-5">
                        Berbagai layanan kesehatan lengkap untuk memenuhi kebutuhan medis Anda.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                        <h5>Poli Umum</h5>
                        <p class="text-muted">Konsultasi kesehatan umum dan pemeriksaan rutin.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-tooth fa-3x text-primary mb-3"></i>
                        <h5>Poli Gigi</h5>
                        <p class="text-muted">Perawatan gigi dan mulut oleh dokter gigi spesialis.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                        <h5>Poli Jantung</h5>
                        <p class="text-muted">Pemeriksaan dan perawatan penyakit jantung.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-baby fa-3x text-primary mb-3"></i>
                        <h5>Poli Anak</h5>
                        <p class="text-muted">Perawatan kesehatan khusus untuk anak-anak.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Mission Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card h-100 p-5">
                        <h3 class="fw-bold text-primary mb-4">
                            <i class="fas fa-eye me-2"></i>Visi
                        </h3>
                        <p class="lead">
                            Menjadi rumah sakit terdepan dalam memberikan pelayanan kesehatan berkualitas tinggi dengan standar internasional.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100 p-5">
                        <h3 class="fw-bold text-primary mb-4">
                            <i class="fas fa-target me-2"></i>Misi
                        </h3>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Memberikan pelayanan medis terbaik</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Menggunakan teknologi medis terdepan</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mengutamakan kepuasan pasien</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Membangun tim medis profesional</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">Hubungi Kami</h2>
                    <p class="lead text-muted mb-5">
                        Siap melayani kebutuhan kesehatan Anda. Hubungi kami untuk informasi lebih lanjut.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                        <h5>Alamat</h5>
                        <p class="text-muted">Jl. Kesehatan No. 123<br>Jakarta Selatan 12345</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                        <h5>Telepon</h5>
                        <p class="text-muted">(021) 1234-5678<br>Emergency: (021) 9999-8888</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                        <h5>Email</h5>
                        <p class="text-muted">info@rssehatsentosa.com<br>admin@rssehatsentosa.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4" style="background: #2c3e50;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white mb-0">
                        &copy; 2024 Rumah Sakit Sehat Sentosa. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chat Widget -->
    @include('components.chat-widget')
</body>
</html>