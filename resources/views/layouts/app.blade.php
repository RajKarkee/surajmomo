<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frozen Momo - Delicious Frozen Momos, Anytime!</title>
    <meta name="description" content="Delicious frozen momos, hygienically prepared and frozen fresh for you.">
    <meta name="keywords" content="frozen momo, chicken momo, veg momo, nepali momo, buy momo">
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Frozen Momo - Delicious Frozen Momos">
    <meta property="og:description" content="Fresh taste, frozen to perfection. Order now!">
    <meta property="og:image" content="https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=800">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @stack('scripts')
    <style>
        :root {
            --primary-color: {{ $globalSettings->primary_color }};
            --secondary-color: {{ $globalSettings->secondary_color }};
            --accent-color: {{ $globalSettings->accent_color }};
            --dark-color: {{ $globalSettings->dark_color }};
            --light-color: {{ $globalSettings->light_color }};
            --white: {{ $globalSettings->white_color }};
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --gradient: linear-gradient(135deg,
                    var(--primary-color),
                    var(--accent-color));
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @yield('content')
    @include('partials.footer')
    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="cartItems"></div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total: Rs. <span id="cartTotal">0</span></h5>
                        </div>
                        <a href="{{ route('product') }}" class="btn btn-secondary">Continue Shopping</a>


                        <button type="button" class="btn btn-custom" onclick="checkout()">Checkout</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="fullName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Delivery Address</label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-control" name="payment" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash on Delivery</option>
                                <option value="esewa">eSewa</option>
                                <option value="khalti">Khalti</option>
                            </select>
                        </div>
                        <div class="order-summary">
                            <h6>Order Summary:</h6>
                            <div id="orderSummary"></div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total: Rs. <span id="orderTotal">0</span></strong>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="placeOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
