{{-- resources/views/katalog/index.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laptop Store') }} - Katalog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-body-bg: #0a0a0a;
            --bs-body-color: #e5e7eb;
            --primary-gold: #f59e0b;
            --primary-gold-hover: #d97706;
            --dark-card: rgba(31, 41, 55, 0.5);
            --glass-bg: rgba(0, 0, 0, 0.3);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 50%, #1a1a1a 100%);
            min-height: 100vh;
        }

        /* Navbar Glass Effect */
        .navbar-glass {
            backdrop-filter: blur(10px);
            background: var(--glass-bg) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            color: var(--primary-gold) !important;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .nav-link {
            color: #d1d5db !important;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-gold) !important;
        }

        .btn-gold {
            background: var(--primary-gold);
            border: none;
            color: #000;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-gold:hover {
            background: var(--primary-gold-hover);
            color: #000;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 600px;
            overflow: hidden;
            margin-top: 76px;
        }

        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.4;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.7), rgba(10,10,10,1));
        }

        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            color: #fff;
        }

        .hero-gold {
            color: var(--primary-gold);
        }

        /* Card Styling */
        .product-card {
            background: var(--dark-card);
            backdrop-filter: blur(5px);
            border: 1px solid #374151;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-gold);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.2);
        }

        .product-img-wrapper {
            height: 250px;
            background: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #10b981;
            color: white;
        }

        .badge-danger {
            background: #ef4444;
            color: white;
        }

        .product-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-gold);
        }

        .filter-card {
            background: var(--dark-card);
            backdrop-filter: blur(5px);
            border: 1px solid #374151;
            border-radius: 1rem;
        }

        .form-control, .form-select {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid #374151;
            color: #e5e7eb;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(17, 24, 39, 0.9);
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
            color: #e5e7eb;
        }

        .form-control::placeholder {
            color: #6b7280;
        }

        .form-select option {
            background: #1f2937;
            color: #e5e7eb;
        }

        /* Footer */
        footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 1px solid #1f2937;
            margin-top: 5rem;
        }

        footer a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--primary-gold);
        }

        .text-muted {
            color: #9ca3af !important;
        }

        .btn-outline-gold {
            border: 1px solid #374151;
            color: #e5e7eb;
            background: #374151;
        }

        .btn-outline-gold:hover {
            background: #4b5563;
            color: #fff;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-glass">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-laptop"></i> Laptop Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item ms-2">
                        <a class="btn btn-gold btn-sm" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <img src="{{ asset('images/hero.jpg') }}" alt="Hero" class="hero-image">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="hero-title mb-4">
                            Temukan Laptop <br>
                            <span class="hero-gold">Impian Anda</span>
                        </h1>
                        <p class="lead text-muted mb-4">
                            Koleksi laptop terlengkap dengan spesifikasi terbaik untuk kebutuhan kerja, gaming, dan entertainment. 
                            Dapatkan harga terbaik dan garansi resmi.
                        </p>
                        <a href="#katalog" class="btn btn-gold btn-lg px-5 py-3">
                            <i class="bi bi-arrow-down-circle me-2"></i> Lihat Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="katalog" class="container py-5">
        <div class="filter-card p-4 mb-5">
            <form action="{{ route('katalog.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   class="form-control form-control-lg pe-5" 
                                   placeholder="Cari laptop (nama, merk, spesifikasi)...">
                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="kategori" class="form-select form-select-lg">
                            <option value="">Semua Kategori</option>
                            <option value="gaming" {{ request('kategori') == 'gaming' ? 'selected' : '' }}>Gaming</option>
                            <option value="office" {{ request('kategori') == 'office' ? 'selected' : '' }}>Office</option>
                            <option value="ultrabook" {{ request('kategori') == 'ultrabook' ? 'selected' : '' }}>Ultrabook</option>
                            <option value="workstation" {{ request('kategori') == 'workstation' ? 'selected' : '' }}>Workstation</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('katalog.index') }}" class="btn btn-outline-gold">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                    <button type="submit" class="btn btn-gold px-4">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="mb-4">
            <h2 class="display-6 fw-bold text-white mb-2">Katalog Laptop</h2>
            <p class="text-muted">Menampilkan {{ $produk->count() }} produk</p>
        </div>

        <div class="row g-4">
            @forelse($produk as $item)
            <div class="col-md-6 col-lg-4">
                <div class="product-card h-100">
                    <div class="product-img-wrapper">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama_produk }}" 
                                 class="product-img">
                        @else
                            <i class="bi bi-laptop" style="font-size: 5rem; color: #374151;"></i>
                        @endif
                        
                        @if($item->stok > 0)
                            <span class="product-badge badge-success">
                                Stok: {{ $item->stok }}
                            </span>
                        @else
                            <span class="product-badge badge-danger">
                                Habis
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="mb-2">
                            <span class="badge" style="background: var(--primary-gold); color: #000;">
                                {{ $item->merk }}
                            </span>
                        </div>
                        <h5 class="text-white fw-bold mb-3">{{ $item->nama_produk }}</h5>
                        <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->spesifikasi }}
                        </p>
                        <div class="product-price mb-4">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-gold flex-fill">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <button class="btn btn-outline-gold">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 5rem; color: #374151;"></i>
                    <h3 class="text-muted mt-4">Produk tidak ditemukan</h3>
                    <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($produk->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $produk->links() }}
        </div>
        @endif
    </div>

    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <h5 class="text-white fw-bold mb-3">
                        <i class="bi bi-laptop"></i> Laptop Store
                    </h5>
                    <p class="text-muted">
                        Toko laptop terpercaya dengan koleksi lengkap dan harga terbaik.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index') }}">Katalog</a></li>
                        <li class="mb-2"><a href="#">Tentang</a></li>
                        <li class="mb-2"><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Kategori</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'gaming']) }}">Gaming</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'office']) }}">Office</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'ultrabook']) }}">Ultrabook</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'workstation']) }}">Workstation</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Kontak</h6>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="bi bi-geo-alt"></i> Bekasi, West Java, ID</li>
                        <li class="mb-2"><i class="bi bi-telephone"></i> +62 xxx-xxxx-xxxx</li>
                        <li class="mb-2"><i class="bi bi-envelope"></i> info@laptopstore.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: #374151;">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; 2025 Laptop Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>