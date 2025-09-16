    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/" onclick="showPage('home')">
                @if ($globalSettings->logo_path)
                    <img src="{{ asset('storage/' . $globalSettings->logo_path) }}"
                        alt="{{ $globalSettings->site_name ?? 'Logo' }}" class="logo me-2">
                @else
                    <i class="fas fa-utensils me-2 text-primary" style="font-size: 1.5rem;"></i>
                @endif
                <span class="fw-bold">{{ $globalSettings->site_name ?? 'Frozen Momo' }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('login')">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" onclick="toggleCart()">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cartBadge">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
