@extends('layouts.app')
@section('content')
    <div id="home" class="page-section active">
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content fade-in">
                    <h1>Delicious Frozen Momos, Anytime!</h1>
                    <p>Fresh taste, frozen to perfection.</p>
                    <div class="hero-buttons">
                        <button class="btn btn-custom" onclick="window.location='{{ route('product') }}'">Shop Now</button>
                        <button class="btn btn-outline-custom" onclick="window.location='{{ route('about') }}'">Learn
                            More</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-highlights">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="mb-4 fade-in">Our Bestsellers</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <img src="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=400&h=300&fit=crop"
                                    alt="Chicken Momo" style="height: 100%; width: 100%; object-fit: cover;">
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Chicken Momo</h5>
                                    <p class="product-price mb-3">Rs. 250</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(1)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop"
                                    alt="Veg Momo" style="height: 100%; width: 100%; object-fit: cover;">
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Veg Momo</h5>
                                    <p class="product-price mb-3">Rs. 200</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(2)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <img src="https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&h=300&fit=crop"
                                    alt="Paneer Momo" style="height: 100%; width: 100%; object-fit: cover;">
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Paneer Momo</h5>
                                    <p class="product-price mb-3">Rs. 280</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(3)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <img src="https://images.unsplash.com/photo-1563379091755-de3815efea9b?w=400&h=300&fit=crop"
                                    alt="Buff Momo" style="height: 100%; width: 100%; object-fit: cover;">
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Buff Momo</h5>
                                    <p class="product-price mb-3">Rs. 300</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(4)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <!-- No image -->
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Chicken Chilli Momo</h5>
                                    <p class="product-price mb-3">Rs. 320</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(5)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <!-- No image -->
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Mixed Veg Momo</h5>
                                    <p class="product-price mb-3">Rs. 230</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(6)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <!-- No image -->
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Cheese Corn Momo</h5>
                                    <p class="product-price mb-3">Rs. 270</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(7)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4 d-flex">
                        <div class="product-card fade-in w-100 d-flex flex-column">
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <!-- No image -->
                            </div>
                            <div class="product-info flex-grow-1 d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="product-name mb-2">Schezwan Momo</h5>
                                    <p class="product-price mb-3">Rs. 310</p>
                                </div>
                                <button class="btn btn-sm btn-custom w-100 mt-auto" onclick="addToCart(8)"><i
                                        class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('product') }}">
                <button class="btn btn-outline-custom">View All Products</button>
            </a>
        </div>
        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="mb-4 fade-in">Why Choose {{ $globalSettings->site_name ?? 'Frozen Momo' }}?</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4>Quality Ingredients</h4>
                            <p>Fresh, premium ingredients sourced locally for authentic taste.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-snowflake"></i>
                            </div>
                            <h4>Frozen Fresh</h4>
                            <p>Advanced freezing technology preserves taste and nutrition.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-truck-fast"></i>
                            </div>
                            <h4>Fast Delivery</h4>
                            <p>Quick and reliable delivery to your doorstep.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>Trusted Taste</h4>
                            <p>Loved by thousands of customers across Nepal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
