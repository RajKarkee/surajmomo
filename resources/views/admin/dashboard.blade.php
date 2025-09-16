@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body text-center p-5">
                    <h2 class="mb-3"
                        style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-utensils me-3"></i>Welcome to Momo Admin Panel
                    </h2>
                    <p class="lead text-muted">Manage your delicious momo products with ease and style</p>
                    <div class="mt-4">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-modern-primary me-3">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                        <button class="btn btn-modern-success" onclick="refreshPreview()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Total Products
                        </div>
                        <div class="h3 mb-0 font-weight-bold" style="color: #2c3e50;">{{ $totalProducts ?? 0 }}</div>
                        <small class="text-muted">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            All time
                        </small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Active Products
                        </div>
                        <div class="h3 mb-0 font-weight-bold" style="color: #2c3e50;">{{ $activeProducts ?? 0 }}</div>
                        <small class="text-muted">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Currently live
                        </small>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Categories
                        </div>
                        <div class="h3 mb-0 font-weight-bold" style="color: #2c3e50;">4</div>
                        <small class="text-muted">
                            <i class="fas fa-layer-group text-info me-1"></i>
                            Momo types
                        </small>
                    </div>
                    <div class="text-info" style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card border-left-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                            style="font-size: 0.75rem; letter-spacing: 1px;">
                            Inactive Products
                        </div>
                        <div class="h3 mb-0 font-weight-bold" style="color: #2c3e50;">
                            {{ ($totalProducts ?? 0) - ($activeProducts ?? 0) }}</div>
                        <small class="text-muted">
                            <i class="fas fa-pause-circle text-warning me-1"></i>
                            Not visible
                        </small>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem; opacity: 0.3;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.products.create') }}"
                                class="btn btn-modern-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                                <i class="fas fa-plus fa-2x mb-3"></i>
                                <span class="fw-bold">Add New Product</span>
                                <small class="opacity-75">Create momo item</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.products') }}"
                                class="btn btn-modern-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                                <i class="fas fa-list fa-2x mb-3"></i>
                                <span class="fw-bold">Manage Products</span>
                                <small class="opacity-75">View all items</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('home') }}" target="_blank"
                                class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                                <i class="fas fa-external-link-alt fa-2x mb-3"></i>
                                <span class="fw-bold">View Website</span>
                                <small class="opacity-75">Open frontend</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="/api/products" target="_blank"
                                class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                                <i class="fas fa-code fa-2x mb-3"></i>
                                <span class="fw-bold">API Endpoint</span>
                                <small class="opacity-75">View JSON data</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-clock me-2"></i>Recent Products
                        </h6>
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (isset($recentProducts) && $recentProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Spice Level</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($product->image_url)
                                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                            class="product-image me-3">
                                                    @else
                                                        <div
                                                            class="bg-light rounded me-3 d-flex align-items-center justify-content-center product-image">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                                        <small
                                                            class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-modern bg-secondary">{{ ucfirst($product->category) }}</span>
                                            </td>
                                            <td class="fw-bold text-success">₹{{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-modern {{ $product->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($product->spice_level)
                                                    @php
                                                        $spiceColor = match ($product->spice_level) {
                                                            'mild' => 'bg-info',
                                                            'medium' => 'bg-warning',
                                                            'spicy' => 'bg-danger',
                                                            'very_spicy' => 'bg-danger',
                                                            default => 'bg-secondary',
                                                        };
                                                    @endphp
                                                    <span class="badge badge-modern {{ $spiceColor }}">
                                                        {{ ucfirst(str_replace('_', ' ', $product->spice_level)) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ $product->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group-modern" role="group">
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteProduct({{ $product->id }})" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-box"></i>
                            <h5>No products found</h5>
                            <p class="text-muted">Get started by creating your first momo product!</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-modern-primary">
                                <i class="fas fa-plus me-2"></i>Create Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add smooth animations to stats cards
            $('.stats-card').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });

            // Add hover effects to quick action buttons
            $('.btn-modern-primary, .btn-modern-success').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
        });

        // Function to delete product with confirmation
        function deleteProduct(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form for deletion
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/products/${productId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endpush
