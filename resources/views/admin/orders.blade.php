@extends('admin.layout')
@section('title', 'Orders')
@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">All Orders</h1>
        </div>
        <div class="card shadow-sm">
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Business</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Map</th>
                            <th>Ordered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ ucfirst($order->order_type) }}</td>
                                <td>{{ $order->business_name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    @if ($order->map_coordinates)
                                        <a href="https://maps.google.com/?q={{ $order->map_coordinates }}"
                                            target="_blank">View Map</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $order->ordered_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <!-- View button -->
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#orderModal{{ $order->id }}">View</button>

                                    <!-- Delete form/button (inline) -->
                                    <form method="POST" action="{{ route('admin.orders.delete', $order->id) }}"
                                        class="d-inline delete-order-form" id="delete-order-{{ $order->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-order-btn"
                                            data-id="{{ $order->id }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Only render modals if there are orders -->
    @if (count($orders))
        @foreach ($orders as $order)
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order
                                #{{ $order->order_code }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
                            <div><strong>Type:</strong> {{ ucfirst($order->order_type) }}</div>
                            @if ($order->order_type === 'business')
                                <div><strong>Business:</strong> {{ $order->business_name }}</div>
                            @endif
                            <div><strong>Address:</strong> {{ $order->address }}</div>
                            <div><strong>Phone:</strong> {{ $order->phone }}</div>
                            @if ($order->map_coordinates)
                                <div class="my-2"><strong>Map:</strong><br>
                                    <iframe width="100%" height="200" style="border:0;" loading="lazy" allowfullscreen
                                        src="https://maps.google.com/maps?q={{ $order->map_coordinates }}&output=embed"></iframe>
                                </div>
                            @endif
                            <div class="my-2"><strong>Ordered At:</strong>
                                {{ $order->ordered_at->format('Y-m-d H:i') }}</div>
                            <hr>
                            <strong>Items:</strong>
                            <table class="table table-sm table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->cart as $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>Rs. {{ $item['price'] }}</td>
                                            <td>Rs. {{ $item['price'] * $item['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end fw-bold">Total: Rs.
                                {{ collect($order->cart)->sum(function ($i) {return $i['price'] * $i['quantity'];}) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Make sure Bootstrap JS is loaded only once, preferably in your layout --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple modal handling without complex event listeners
            const modalButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

            modalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Force remove any existing backdrops before opening new modal
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                });
            });

            // Handle modal close events
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hide.bs.modal', function() {
                    // Clean up when modal is being hidden
                    setTimeout(() => {
                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 100);
                });
            });

            // Emergency cleanup on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    setTimeout(() => {
                        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 200);
                }
            });

            // Delete confirmation handler
            document.querySelectorAll('.delete-order-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    var id = this.getAttribute('data-id');
                    if (!id) return;
                    if (confirm(
                            'Are you sure you want to delete this order? This action cannot be undone.'
                        )) {
                        var form = document.getElementById('delete-order-' + id);
                        if (form) form.submit();
                    }
                });
            });
        });
    </script>
    <style>
        /* Prevent table data from overflowing */
        .table td,
        .table th {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            max-width: 180px;
        }

        /* Responsive modal for small screens */
        @media (max-width: 768px) {
            .modal-lg {
                max-width: 98vw;
            }
        }

        /* Fix z-index stacking for modal and backdrop */
        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }
    </style>
@endsection
