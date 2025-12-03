<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Kamar - KosanKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1e40af;
            --light-blue: #dbeafe;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.2);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 60px 0 40px;
            margin-bottom: 40px;
        }
        
        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            margin-bottom: 30px;
        }
        
        .room-card {
            background: white;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }
        
        .room-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--light-blue) 0%, #bfdbfe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .room-card .card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .room-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .room-card .card-text {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .room-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #475569;
        }
        
        .room-info-item i {
            width: 20px;
            font-size: 0.9rem;
        }
        
        .price-status-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            margin-bottom: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }
        
        .price-badge {
            background: var(--primary-blue);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            color: white;
        }
        
        .status-badge.bg-success {
            background-color: #10b981 !important;
        }
        
        .status-badge.bg-secondary {
            background-color: #6b7280 !important;
        }
        
        .stok-info {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 12px;
        }
        
        .btn-book {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            width: 100%;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-book:hover:not(:disabled) {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-book:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            opacity: 0.7;
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
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('rooms.index') }}">Cari Kamar</a>
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

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">Cari Kamar Kosan</h1>
            <p class="lead mb-0">Temukan kamar yang sesuai dengan kebutuhan Anda</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        @livewire('room-list')
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
