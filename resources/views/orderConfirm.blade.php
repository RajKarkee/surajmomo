@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <div class="container">
        <h1 class="my-4">Order Confirmation</h1>
        <div class="row g-4 justify-content-center flex-lg-row flex-column-reverse">
            <div class="col-lg-8 col-12">
                <div class="card shadow bill-card mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-receipt me-2"></i>Order Bill</span>
                        <span class="fw-bold" id="billDate"></span>
                    </div>
                    <div class="card-body">
                        <div id="orderSummary"></div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-4 text-success">Rs. <span id="orderTotal">0</span></span>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-4">
                    <button class="btn btn-success btn-lg w-100 w-md-auto" id="confirmOrderBtn">
                        <i class="fas fa-check-circle me-2"></i>Confirm Order
                    </button>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card shadow bill-card mb-4 h-100">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-history me-2"></i>Recent Orders
                    </div>
                    <div class="card-body p-2" id="recentOrdersList">
                        <p class="text-muted mb-0">No recent orders.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">Delivery Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userDetailsForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label me-3">Order Type</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="orderType" id="personalRadio"
                                    value="personal" checked>
                                <label class="form-check-label" for="personalRadio">Personal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="orderType" id="businessRadio"
                                    value="business">
                                <label class="form-check-label" for="businessRadio">Business</label>
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="businessNameGroup">
                            <label for="businessName" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="businessName" name="businessName">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                pattern="[0-9]{10,15}">
                        </div>
                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Email Address (Optional)</label>
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail"
                                placeholder="your@email.com">
                            <div class="form-text">We'll send you order updates and receipts at this email.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Delivery Location on Map</label>
                            <div id="leafletMap" style="height: 220px; border-radius: 8px; overflow: hidden;"></div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="useMyLocationBtn">
                                <i class="fas fa-location-arrow me-1"></i>Use My Location
                            </button>
                            <input type="hidden" id="mapCoordinates" name="mapCoordinates">
                            <div class="form-text">Drag the marker or click on the map to select your delivery location.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Previous Order Modal -->
    <div class="modal fade" id="previousOrderModal" tabindex="-1" aria-labelledby="previousOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previousOrderModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previousOrderDetails"></div>
            </div>
        </div>
    </div>

    <!-- Loading overlay (replaced with polished panel + success/error states) -->
    <div id="orderLoadingOverlay" class="order-loading-overlay" aria-hidden="true" role="status" aria-live="polite">
        <div class="overlay-panel text-center" role="dialog" aria-modal="true" aria-label="Processing order">
            <!-- Spinner state -->
            <div id="overlaySpinner" class="spinner-wrap">
                <div class="big-spinner" aria-hidden="true">
                    <div class="spinner-border text-white" role="status" style="width:4rem;height:4rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="overlay-message mt-3 text-white fw-semibold">Processing your order…</div>
            </div>

            <!-- Success state -->
            <div id="overlaySuccess" class="success-wrap d-none">
                <svg class="checkmark" viewBox="0 0 52 52" aria-hidden="true">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark__check" fill="none" d="M14 27l7 7 17-17" />
                </svg>
                <div class="overlay-message mt-3 text-white h5 mb-0">Order confirmed</div>
                <div id="overlayOrderId" class="text-white-50 small mt-1"></div>
            </div>

            <!-- Error state -->
            <div id="overlayError" class="error-wrap d-none">
                <div class="error-icon mb-2">&#9888;</div>
                <div class="overlay-message mt-1 text-white fw-semibold">Something went wrong</div>
                <div id="overlayErrorText" class="text-white-50 small mt-1">Order saved locally.</div>
            </div>
        </div>
    </div>

    <!-- Toast for a modern confirmation -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2150;">
        <div id="orderToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">Order placed successfully.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        // Bill date
        document.getElementById('billDate').textContent = new Date().toLocaleString();

        // Render bill-style order summary
        function renderOrderSummary() {
            const orderSummary = document.getElementById('orderSummary');
            const orderTotal = document.getElementById('orderTotal');
            const cart = JSON.parse(localStorage.getItem('frozenMomoCart')) || [];
            if (cart.length === 0) {
                orderSummary.innerHTML = '<p class="text-center text-muted">Your cart is empty.</p>';
                orderTotal.textContent = '0';
                return;
            }
            let summaryHtml =
                '<table class="table table-borderless mb-0"><thead><tr><th>Item</th><th class="text-end">Qty</th><th class="text-end">Price</th><th class="text-end">Total</th></tr></thead><tbody>';
            let total = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                summaryHtml += `
                    <tr>
                        <td>${item.name}</td>
                        <td class="text-end">${item.quantity}</td>
                        <td class="text-end">Rs. ${item.price}</td>
                        <td class="text-end">Rs. ${itemTotal}</td>
                    </tr>
                `;
            });
            summaryHtml += '</tbody></table>';
            orderSummary.innerHTML = summaryHtml;
            orderTotal.textContent = total;
        }
        renderOrderSummary();

        // Show modal on confirm button click
        document.getElementById('confirmOrderBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            modal.show();
        });

        // Toggle business name field
        document.querySelectorAll('input[name="orderType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const businessGroup = document.getElementById('businessNameGroup');
                if (this.value === 'business') {
                    businessGroup.classList.remove('d-none');
                    document.getElementById('businessName').setAttribute('required', 'required');
                } else {
                    businessGroup.classList.add('d-none');
                    document.getElementById('businessName').removeAttribute('required');
                }
            });
        });

        // LEAFLET MAP FOR LOCATION SELECTION
        let map, marker;

        function initLeafletMap() {
            if (map) return; // Only initialize once
            map = L.map('leafletMap').setView([27.7172, 85.3240], 13); // Default: Kathmandu
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            marker = L.marker([27.7172, 85.3240], {
                draggable: true
            }).addTo(map);
            document.getElementById('mapCoordinates').value = '27.7172,85.3240';
            marker.on('dragend', function(e) {
                const latlng = marker.getLatLng();
                document.getElementById('mapCoordinates').value = latlng.lat + ',' + latlng.lng;
            });
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('mapCoordinates').value = e.latlng.lat + ',' + e.latlng.lng;
            });
        }
        // Show map when modal opens
        document.getElementById('userDetailsModal').addEventListener('shown.bs.modal', function() {
            setTimeout(() => {
                initLeafletMap();
                map.invalidateSize();
            }, 200);
        });
        // Use device location
        document.getElementById('useMyLocationBtn').addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }
            navigator.geolocation.getCurrentPosition(function(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                document.getElementById('mapCoordinates').value = lat + ',' + lng;
            }, function() {
                alert('Unable to retrieve your location.');
            });
        });

        // Handle form submit (updated: polished overlay + success animation + toast)
        document.getElementById('userDetailsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const prevBtnHtml = submitBtn.innerHTML;

            // UI references
            const overlay = document.getElementById('orderLoadingOverlay');
            const spinnerWrap = document.getElementById('overlaySpinner');
            const successWrap = document.getElementById('overlaySuccess');
            const errorWrap = document.getElementById('overlayError');
            const overlayOrderId = document.getElementById('overlayOrderId');
            const overlayErrorText = document.getElementById('overlayErrorText');
            const toastEl = document.getElementById('orderToast');

            // Show loading overlay
            submitBtn.setAttribute('disabled', 'disabled');
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...';
            overlay.classList.add('show');
            overlay.setAttribute('aria-hidden', 'false');
            spinnerWrap.classList.remove('d-none');
            successWrap.classList.add('d-none');
            errorWrap.classList.add('d-none');

            let order;
            try {
                const formData = new FormData(form);
                const details = Object.fromEntries(formData.entries());
                const cart = JSON.parse(localStorage.getItem('frozenMomoCart')) || [];
                order = {
                    id: 'ORD' + Date.now(),
                    date: new Date().toLocaleString(),
                    details,
                    cart
                };

                // Save to recent orders (localStorage)
                let recentOrders = JSON.parse(localStorage.getItem('recentOrders')) || [];
                recentOrders.unshift(order);
                if (recentOrders.length > 5) recentOrders = recentOrders.slice(0, 5);
                localStorage.setItem('recentOrders', JSON.stringify(recentOrders));

                // Send to backend
                let sentOk = false;
                try {
                    const response = await fetch('/orderConfirm', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(order)
                    });
                    sentOk = response && response.ok;
                } catch (err) {
                    console.error('Order POST error:', err);
                    sentOk = false;
                }

                // Clear cart and update UI (we saved recentOrders earlier)
                localStorage.removeItem('frozenMomoCart');
                renderOrderSummary();
                renderRecentOrders();

                if (sentOk) {
                    // Show success animation & toast
                    spinnerWrap.classList.add('d-none');
                    overlayOrderId.textContent = order.id;
                    successWrap.classList.remove('d-none');

                    // Trigger CSS animation by reflow (if needed)
                    // show toast
                    if (toastEl) new bootstrap.Toast(toastEl).show();

                    // wait briefly so user can see animation
                    await new Promise(res => setTimeout(res, 1400));
                } else {
                    // Show error state (informative)
                    spinnerWrap.classList.add('d-none');
                    errorWrap.classList.remove('d-none');
                    overlayErrorText.textContent = 'Order saved locally, but failed to send to server.';
                    await new Promise(res => setTimeout(res, 1600));
                }

                // Close modal (if open) and move focus back
                try {
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById(
                        'userDetailsModal'));
                    if (modalInstance) modalInstance.hide();
                } catch (err) {
                    /* ignore */ }
                document.getElementById('confirmOrderBtn').focus();
            } finally {
                // Always hide overlay and restore button
                overlay.classList.remove('show');
                overlay.setAttribute('aria-hidden', 'true');
                submitBtn.removeAttribute('disabled');
                submitBtn.innerHTML = prevBtnHtml;
            }
        });

        // Render recent orders
        function renderRecentOrders() {
            const list = document.getElementById('recentOrdersList');
            let recentOrders = JSON.parse(localStorage.getItem('recentOrders')) || [];
            if (recentOrders.length === 0) {
                list.innerHTML = '<p class="text-muted mb-0">No recent orders.</p>';
                return;
            }
            let html = '<ul class="list-group list-group-flush">';
            recentOrders.forEach(order => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center recent-order-item" data-order-id="${order.id}" style="cursor:pointer;">
                    <span class="text-truncate" style="max-width:120px;">${order.id}</span>
                    <span class="badge bg-primary">${order.date}</span>
                </li>`;
            });
            html += '</ul>';
            list.innerHTML = html;
        }
        renderRecentOrders();

        // Show previous order modal
        document.getElementById('recentOrdersList').addEventListener('click', function(e) {
            const item = e.target.closest('.recent-order-item');
            if (!item) return;
            const orderId = item.getAttribute('data-order-id');
            let recentOrders = JSON.parse(localStorage.getItem('recentOrders')) || [];
            const order = recentOrders.find(o => o.id === orderId);
            if (!order) return;
            let html =
                `<div><strong>Order ID:</strong> ${order.id}<br><strong>Date:</strong> ${order.date}</div><hr>`;
            html += `<div><strong>Name:</strong> ${order.details.customerName}<br>`;
            if (order.details.orderType === 'business') {
                html += `<strong>Business:</strong> ${order.details.businessName}<br>`;
            }
            html +=
                `<strong>Address:</strong> ${order.details.address}<br><strong>Phone:</strong> ${order.details.phone}<br>`;
            if (order.details.mapCoordinates) {
                html +=
                    `<strong>Map:</strong><br><div id='prevOrderMap' style='height:150px; border-radius:8px;'></div><br>`;
            }
            html += '</div><hr>';
            html += '<strong>Items:</strong><ul>';
            order.cart.forEach(item => {
                html += `<li>${item.name} x ${item.quantity} (Rs. ${item.price} each)</li>`;
            });
            html += '</ul>';
            const total = order.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            html += `<div class="mt-2"><strong>Total:</strong> Rs. ${total}</div>`;
            document.getElementById('previousOrderDetails').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('previousOrderModal'));
            modal.show();
            // Show map for previous order
            if (order.details.mapCoordinates) {
                setTimeout(() => {
                    const coords = order.details.mapCoordinates.split(',');
                    const prevMap = L.map('prevOrderMap').setView([parseFloat(coords[0]), parseFloat(coords[
                        1])], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(prevMap);
                    L.marker([parseFloat(coords[0]), parseFloat(coords[1])]).addTo(prevMap);
                }, 300);
            }
        });
    </script>
    <style>
        .bill-card {
            border-radius: 12px;
            border: none;
        }

        .bill-card .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .bill-card .table th,
        .bill-card .table td {
            vertical-align: middle;
        }

        #leafletMap,
        #prevOrderMap {
            min-height: 150px;
        }

        @media (max-width: 991.98px) {
            .bill-card {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 767.98px) {

            .bill-card .card-header,
            .bill-card .card-body {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .bill-card .table th,
            .bill-card .table td {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 575.98px) {

            .bill-card .card-header,
            .bill-card .card-body {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .bill-card .table th,
            .bill-card .table td {
                font-size: 0.9rem;
            }
        }

        /* Polished loading overlay */
        .order-loading-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(2, 6, 23, 0.6), rgba(2, 6, 23, 0.75));
            backdrop-filter: blur(6px) saturate(120%);
            z-index: 2100;
            padding: 2rem;
        }

        .order-loading-overlay.show {
            display: flex;
        }

        .order-loading-overlay .overlay-panel {
            max-width: 360px;
            width: 100%;
            padding: 28px 20px;
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .overlay-message {
            font-size: 1rem;
        }

        /* Spinner center */
        .big-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated checkmark */
        .checkmark {
            width: 84px;
            height: 84px;
            display: block;
            margin: 0 auto;
        }

        .checkmark__circle {
            stroke: rgba(255, 255, 255, 0.12);
            stroke-width: 2;
        }

        .checkmark__check {
            stroke: #fff;
            stroke-width: 3.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: draw-check 0.6s ease 0.15s forwards;
        }

        @keyframes draw-check {
            to {
                stroke-dashoffset: 0;
            }
        }

        /* Error */
        .error-wrap .error-icon {
            font-size: 2.4rem;
            color: #ffd166;
        }

        /* Small responsive tweaks */
        @media (max-width: 420px) {
            .order-loading-overlay .overlay-panel {
                padding: 18px;
                border-radius: 12px;
            }

            .overlay-message {
                font-size: 0.95rem;
            }
        }
    </style>
@endsection
