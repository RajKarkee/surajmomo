@extends('layouts.app')
@section('content')
    <div id="product-single" class="page-section">
        <!-- Product Hero Section -->
        <section class="product-hero">
            <div class="container">
                <div class="row align-items-center min-vh-75">
                    <div class="col-lg-6 order-lg-1 order-2">
                        <div class="product-hero-content">
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('product') }}">Products</a></li>
                                    <li class="breadcrumb-item active" id="breadcrumb-product">Loading...</li>
                                </ol>
                            </nav>
                            <div class="product-badge mb-3">
                                <span class="badge bg-primary" id="product-category">Loading...</span>
                                <span class="badge bg-success" id="product-spice">Loading...</span>
                            </div>
                            <h1 class="display-4 fw-bold mb-3" id="product-name">Loading Product...</h1>
                            <p class="lead mb-4" id="product-description">Loading product description...</p>

                            <div class="product-details mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="fas fa-utensils text-primary me-2"></i>
                                            <strong>Ingredients:</strong>
                                            <p class="mb-0 ms-4" id="product-ingredients">Loading...</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <i class="fas fa-pepper-hot text-danger me-2"></i>
                                            <strong>Spice Level:</strong>
                                            <p class="mb-0 ms-4" id="product-spice-level">Loading...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="price-section mb-4">
                                <div class="d-flex align-items-center">
                                    <h2 class="price text-primary mb-0 me-3">Rs. <span id="product-price">0</span></h2>
                                    <div class="quantity-selector">
                                        <label for="quantity" class="form-label mb-0 me-2">Qty:</label>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="decrease-qty">-</button>
                                            <input type="number" class="form-control text-center" id="quantity"
                                                value="1" min="1" max="20">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="increase-qty">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <button class="btn btn-custom btn-lg me-3" id="add-to-cart-btn">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                                <button class="btn btn-outline-custom btn-lg" id="buy-now-btn">
                                    <i class="fas fa-bolt me-2"></i>Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                        <div class="product-image-container">
                            <div class="main-image-wrapper">
                                <img id="product-main-image" src="" alt="Product Image"
                                    class="img-fluid rounded-3 shadow-lg main-product-image">
                                <div class="image-overlay">
                                    <button class="btn btn-light btn-sm zoom-btn" id="zoom-image">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Features Section -->
        <section class="product-features py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center mb-5">Why Choose Our Momos?</h3>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-snowflake"></i>
                            </div>
                            <h5>Frozen Fresh</h5>
                            <p>Instantly frozen to lock in freshness and taste</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h5>Natural Ingredients</h5>
                            <p>Made with fresh, natural ingredients only</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5>Quick Cook</h5>
                            <p>Ready to eat in just 15-20 minutes</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h5>Made with Love</h5>
                            <p>Crafted with traditional recipes and care</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cooking Instructions Section -->
        <section class="cooking-instructions py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h3 class="text-center mb-5">How to Prepare</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="instruction-step text-center">
                                    <div class="step-number">1</div>
                                    <h5>Steam</h5>
                                    <p>Steam for 15-20 minutes in a steamer</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="instruction-step text-center">
                                    <div class="step-number">2</div>
                                    <h5>Pan Fry (Optional)</h5>
                                    <p>Pan fry for 2-3 minutes for crispy texture</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="instruction-step text-center">
                                    <div class="step-number">3</div>
                                    <h5>Serve Hot</h5>
                                    <p>Serve with your favorite dipping sauce</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products Section -->
        <section class="related-products py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center mb-5">You Might Also Like</h3>
                    </div>
                </div>
                <div class="row" id="related-products">
                    <!-- Related products will be loaded here -->
                </div>
            </div>
        </section>
    </div>

    <!-- Image Zoom Modal -->
    <div class="modal fade" id="imageZoomModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="zoom-modal-title">Product Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img id="zoomed-image" src="" alt="Zoomed Product" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Get product ID from URL
                const urlParams = new URLSearchParams(window.location.search);
                const productId = urlParams.get('id');

                // Initialize GSAP timeline
                const tl = gsap.timeline();

                // Fade in page elements
                tl.from('.product-hero-content > *', {
                        duration: 0.8,
                        y: 50,
                        opacity: 0,
                        stagger: 0.1,
                        ease: "power2.out"
                    })
                    .from('.product-image-container', {
                        duration: 1,
                        x: 100,
                        opacity: 0,
                        ease: "power2.out"
                    }, "-=0.5")
                    .from('.feature-card', {
                        duration: 0.6,
                        y: 30,
                        opacity: 0,
                        stagger: 0.1,
                        ease: "power2.out"
                    }, "-=0.3");

                // Load product data
                if (productId) {
                    loadProduct(productId);
                } else {
                    // Redirect to products page if no ID
                    window.location.href = '{{ route('product') }}';
                }

                // Quantity controls
                $('#increase-qty').click(function() {
                    const qty = parseInt($('#quantity').val());
                    if (qty < 20) {
                        $('#quantity').val(qty + 1);
                        updatePrice();
                    }
                });

                $('#decrease-qty').click(function() {
                    const qty = parseInt($('#quantity').val());
                    if (qty > 1) {
                        $('#quantity').val(qty - 1);
                        updatePrice();
                    }
                });

                $('#quantity').on('input', function() {
                    const qty = parseInt($(this).val());
                    if (qty >= 1 && qty <= 20) {
                        updatePrice();
                    }
                });

                // Image zoom functionality
                $('#zoom-image').click(function() {
                    const mainImage = $('#product-main-image').attr('src');
                    const productName = $('#product-name').text();
                    $('#zoomed-image').attr('src', mainImage);
                    $('#zoom-modal-title').text(productName);
                    $('#imageZoomModal').modal('show');
                });

                // Add to cart functionality
                $('#add-to-cart-btn').click(function() {
                    const quantity = parseInt($('#quantity').val());
                    const productData = window.currentProduct;

                    if (productData && typeof addToCart === 'function') {
                        // Animate button
                        gsap.to(this, {
                            duration: 0.1,
                            scale: 0.95,
                            yoyo: true,
                            repeat: 1,
                            ease: "power2.inOut"
                        });

                        // Add to cart with quantity
                        for (let i = 0; i < quantity; i++) {
                            addToCart(productData.id);
                        }

                        // Success animation
                        gsap.fromTo('.btn-custom', {
                            backgroundColor: '#e74c3c'
                        }, {
                            backgroundColor: '#27ae60',
                            duration: 0.3,
                            yoyo: true,
                            repeat: 1
                        });
                    }
                });

                // Buy now functionality
                $('#buy-now-btn').click(function() {
                    $('#add-to-cart-btn').click(); // Add to cart first
                    setTimeout(() => {
                        if (typeof openCart === 'function') {
                            openCart(); // Open cart modal
                        }
                    }, 500);
                });

                // Scroll animations
                gsap.registerPlugin(ScrollTrigger);

                gsap.from('.instruction-step', {
                    duration: 0.8,
                    y: 50,
                    opacity: 0,
                    stagger: 0.2,
                    scrollTrigger: {
                        trigger: '.cooking-instructions',
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            function loadProduct(productId) {
                // Show loading state
                $('#product-name').text('Loading...');
                $('#product-description').text('Loading product details...');

                // Fetch product data
                $.ajax({
                    url: `/api/products/${productId}`,
                    method: 'GET',
                    success: function(product) {
                        // Store product data globally
                        window.currentProduct = product;

                        // Update page content
                        updateProductDisplay(product);

                        // Load related products
                        loadRelatedProducts(product.category, productId);

                        // Animate content update
                        gsap.from('.product-hero-content', {
                            duration: 0.5,
                            opacity: 0,
                            y: 20,
                            ease: "power2.out"
                        });
                    },
                    error: function() {
                        $('#product-name').text('Product Not Found');
                        $('#product-description').text('Sorry, the requested product could not be found.');
                        $('.action-buttons').hide();
                    }
                });
            }

            function updateProductDisplay(product) {
                // Update basic info
                $('#breadcrumb-product').text(product.name);
                $('#product-name').text(product.name);
                $('#product-description').text(product.description);
                $('#product-price').text(product.price);
                $('#product-category').text(product.category.toUpperCase());
                $('#product-ingredients').text(product.ingredients || 'Premium fresh ingredients');

                // Update spice level
                const spiceLevel = product.spice_level || 'mild';
                $('#product-spice-level').text(spiceLevel.charAt(0).toUpperCase() + spiceLevel.slice(1));
                $('#product-spice').text(spiceLevel.toUpperCase());

                // Update spice badge color
                const spiceColors = {
                    'mild': 'bg-success',
                    'medium': 'bg-warning',
                    'spicy': 'bg-danger',
                    'very_spicy': 'bg-dark'
                };
                $('#product-spice').removeClass('bg-success bg-warning bg-danger bg-dark').addClass(spiceColors[spiceLevel] ||
                    'bg-success');

                // Update image
                const imageUrl = product.image_url ||
                    'https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=600&h=400&fit=crop';
                $('#product-main-image').attr('src', imageUrl);

                // Update page title
                document.title = `${product.name} - Frozen Momo`;
            }

            function updatePrice() {
                const basePrice = parseFloat(window.currentProduct?.price || 0);
                const quantity = parseInt($('#quantity').val());
                const totalPrice = (basePrice * quantity).toFixed(2);
                $('#product-price').text(totalPrice);
            }

            function loadRelatedProducts(category, excludeId) {
                $.ajax({
                    url: '/api/products',
                    method: 'GET',
                    success: function(products) {
                        const relatedProducts = products
                            .filter(p => p.category === category && p.id != excludeId)
                            .slice(0, 3);

                        let html = '';
                        relatedProducts.forEach(product => {
                            const imageUrl = product.image_url ||
                                'https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=400&h=300&fit=crop';
                            html += `
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="product-card h-100">
                                    <div class="product-image">
                                        <img src="${imageUrl}" alt="${product.name}" class="img-fluid">
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-name">${product.name}</h5>
                                        <p class="product-price">Rs. ${product.price}</p>
                                        <div class="product-actions">
                                            <a href="?id=${product.id}" class="btn btn-outline-custom btn-sm me-2">View Details</a>
                                            <button class="btn btn-custom btn-sm" onclick="addToCart(${product.id})">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        });

                        $('#related-products').html(html);

                        // Animate related products
                        gsap.from('#related-products .product-card', {
                            duration: 0.6,
                            y: 30,
                            opacity: 0,
                            stagger: 0.1,
                            scrollTrigger: {
                                trigger: '#related-products',
                                start: 'top 80%'
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
