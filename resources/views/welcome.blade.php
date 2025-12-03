<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosanKu - Sistem Manajemen Kosan Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1e40af;
            --light-blue: #dbeafe;
            --dark-blue: #1e3a8a;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.2);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
            z-index: 0;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 1;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--light-blue);
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px;
        }
        
        .btn-primary {
            background: var(--primary-blue);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-light {
            position: relative;
            z-index: 10;
            cursor: pointer;
        }
        
        .btn-outline-primary {
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            cursor: pointer;
        }
        
        .btn-outline-primary:hover {
            background: white;
            color: var(--primary-blue);
            transform: translateY(-2px);
        }
        
        footer {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 40px 0 20px;
        }
        
        .stats-section {
            background: var(--light-blue);
            padding: 60px 0;
        }
        
        .stat-card {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-blue);
        }
        
        .stat-label {
            color: #64748b;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .stat-label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-home me-2"></i>KosanKu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.index') }}">Cari Kamar</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role == 'pemilik' ? route('admin.dashboard') : route('penyewa.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm ms-2">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light btn-sm ms-2" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 fw-bold mb-4">Kelola Kosan Anda dengan Mudah</h1>
                    <p class="lead mb-4">Sistem manajemen kosan modern untuk memudahkan admin dan penyewa dalam mengelola pembayaran, booking, dan keluhan.</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                        <a href="{{ route('rooms.index') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-search me-2"></i>Cari Kamar
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">
                            Daftar Sekarang
                        </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 500 400'%3E%3Crect fill='%23ffffff' x='50' y='50' width='400' height='300' rx='20'/%3E%3Crect fill='%232563eb' x='70' y='70' width='180' height='120' rx='10'/%3E%3Crect fill='%233b82f6' x='270' y='70' width='160' height='120' rx='10'/%3E%3Crect fill='%2360a5fa' x='70' y='210' width='360' height='40' rx='8'/%3E%3Crect fill='%2393c5fd' x='70' y='270' width='360' height='40' rx='8'/%3E%3C/svg%3E" alt="Kosan Illustration" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Kamar Tersedia</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Penyewa Aktif</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Layanan Online</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h5 class="card-title fw-bold">Booking Online</h5>
                            <p class="card-text text-muted">Pesan kamar secara online dengan mudah dan cepat tanpa ribet.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="card-title fw-bold">Pembayaran Digital</h5>
                            <p class="card-text text-muted">Upload bukti pembayaran dan tracking status pembayaran realtime.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <h5 class="card-title fw-bold">Lapor Keluhan</h5>
                            <p class="card-text text-muted">Laporkan keluhan dengan foto dan pantau status perbaikan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <h5 class="card-title fw-bold">Notifikasi Otomatis</h5>
                            <p class="card-text text-muted">Dapatkan pengingat tagihan dan notifikasi penting lainnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h5 class="card-title fw-bold">Riwayat Transaksi</h5>
                            <p class="card-text text-muted">Lihat semua riwayat pembayaran dan tagihan dengan detail.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h5 class="card-title fw-bold">Pengumuman Digital</h5>
                            <p class="card-text text-muted">Terima pengumuman penting langsung di dashboard Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);">
        <div class="container text-center text-white">
            <h2 class="mb-4">Siap Memulai?</h2>
            <p class="lead mb-4">Bergabunglah dengan ribuan penyewa yang sudah merasakan kemudahan</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('rooms.index') }}" class="btn btn-light btn-lg px-5">Lihat Kamar</a>
                @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">Daftar Gratis</a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-home me-2"></i>KosanKu</h5>
                    <p>Sistem manajemen kosan modern untuk kemudahan admin dan penyewa.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('rooms.index') }}" class="text-white text-decoration-none">Cari Kamar</a></li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">Fitur</a></li>
                        @auth
                        <li class="mb-2"><a href="{{ auth()->user()->role == 'pemilik' ? route('admin.dashboard') : route('penyewa.dashboard') }}" class="text-white text-decoration-none">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <p><i class="fas fa-envelope me-2"></i>info@kosanku.com</p>
                    <p><i class="fas fa-phone me-2"></i>+62 812-3456-7890</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} KosanKu. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
