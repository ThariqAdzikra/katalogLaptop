<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laptop Store'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS Global Dimuat dari file eksternal --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    {{-- Stack untuk CSS spesifik per halaman --}}
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-glass">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-laptop"></i>Laptop Store
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    
                    {{-- Link Katalog hanya tampil jika user login --}}
                    @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}" 
                           href="{{ route('katalog.index') }}">
                            <i class="bi bi-grid me-1"></i>Katalog
                        </a>
                    </li>
                    @endif

                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kasir.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="bi bi-cash-register me-1"></i>Kasir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="bi bi-cart-check me-1"></i>Pembelian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="bi bi-bag-check me-1"></i>Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="bi bi-file-earmark-bar-graph me-1"></i>Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" 
                           href="#">
                            <i class="bi bi-people me-1"></i>Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stok.*') ? 'active' : '' }}" 
                           href="{{ route('stok.index') }}">
                            <i class="bi bi-box-seam me-1"></i>Stok
                        </a>
                    </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-nav btn-sm" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i>Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h5>
                        <i class="bi bi-laptop me-2"></i>Laptop Store
                    </h5>
                    <p class="text-muted pe-lg-4">
                        Toko laptop terpercaya dengan koleksi lengkap dan harga terbaik untuk semua kebutuhan Anda. Memberikan solusi teknologi berkualitas sejak 2020.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="me-3" style="font-size: 1.5rem;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-3" style="font-size: 1.5rem;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="me-3" style="font-size: 1.5rem;"><i class="bi bi-twitter"></i></a>
                        <a href="#" style="font-size: 1.5rem;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        @auth
                        <li class="mb-2"><a href="{{ route('katalog.index') }}">Katalog</a></li>
                        <li class="mb-2"><a href="{{ route('stok.index') }}">Stok</a></li>
                        @else
                        <li class="mb-2"><a href="{{ route('katalog.index') }}">Katalog</a></li>
                        @endauth
                        <li class="mb-2"><a href="#">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Kategori</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'gaming']) }}">Gaming</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'office']) }}">Office</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'ultrabook']) }}">Ultrabook</a></li>
                        <li class="mb-2"><a href="{{ route('katalog.index', ['kategori' => 'workstation']) }}">Workstation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Kontak Kami</h6>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt"></i>
                            Pekanbaru, Riau, Indonesia
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone"></i>
                            +62-8127-5403-516
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope"></i>
                            bahlilganteng@gmail.com
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.7);">
                        &copy; {{ date('Y') }} Laptop Store. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="me-3" style="color: rgba(255, 255, 255, 0.7);">Privacy Policy</a>
                    <a href="#" style="color: rgba(255, 255, 255, 0.7);">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Stack untuk JS spesifik per halaman --}}
    @stack('scripts')
</body>
</html>