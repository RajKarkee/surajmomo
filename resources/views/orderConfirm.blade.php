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

        // Handle form submit
        document.getElementById('userDetailsForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const details = Object.fromEntries(formData.entries());
            const cart = JSON.parse(localStorage.getItem('frozenMomoCart')) || [];
            const order = {
                id: 'ORD' + Date.now(),
                date: new Date().toLocaleString(),
                details,
                cart
            };
            // Save to recent orders (localStorage)
            let recentOrders = JSON.parse(localStorage.getItem('recentOrders')) || [];
            recentOrders.unshift(order);
            if (recentOrders.length > 5) recentOrders = recentOrders.slice(0, 5); // Keep only last 5
            localStorage.setItem('recentOrders', JSON.stringify(recentOrders));


            // Send to backend
            try {
                // console.log('About to fetch POST /orderConfirm');
                const response = await fetch('/orderConfirm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(order)
                });
                // console.log('Fetch POST /orderConfirm response:', response);
                if (!response.ok) throw new Error('Failed to submit order to server');
            } catch (err) {
                alert('Order saved locally, but failed to send to server.');
                console.error('Order POST error:', err);
            }
            // Clear cart
            localStorage.removeItem('frozenMomoCart');
            renderOrderSummary();
            renderRecentOrders();
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('userDetailsModal')).hide();
            // Move focus to Confirm Order button for accessibility
            document.getElementById('confirmOrderBtn').focus();
            // Show success
            alert('Order confirmed!');
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
    </style>
@endsection
