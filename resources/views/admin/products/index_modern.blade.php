@extends('admin.layout')

@section('title', 'Products Management')
@section('page-title', 'Products Management')

@section('content')
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"
                style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="fas fa-box me-2"></i>Products Management
            </h2>
            <p class="text-muted mb-0">Manage your delicious momo products</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-modern-primary">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light"
                                    placeholder="Search products..." id="searchInput">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 bg-light" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="steamed">Steamed</option>
                                <option value="fried">Fried</option>
                                <option value="pan-fried">Pan-Fried</option>
                                <option value="special">Special</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 bg-light" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="modern-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-list me-2"></i>All Products
                </h6>
                <span class="badge badge-modern bg-info">{{ $products->total() ?? 0 }} Total</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if (isset($products) && $products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern mb-0" id="productsTable">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Product</th>
                                <th width="120">Category</th>
                                <th width="100">Price</th>
                                <th width="100">Status</th>
                                <th width="120">Spice Level</th>
                                <th width="100">Created</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr data-category="{{ $product->category }}" data-status="{{ $product->status }}">
                                    <td>
                                        <span class="badge badge-modern bg-secondary">#{{ $product->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                    class="product-image me-3" loading="lazy">
                                            @else
                                                <div
                                                    class="bg-light rounded me-3 d-flex align-items-center justify-content-center product-image">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                                <small
                                                    class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                @if ($product->ingredients)
                                                    <br><small class="text-info">
                                                        <i
                                                            class="fas fa-leaf me-1"></i>{{ Str::limit($product->ingredients, 30) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-modern bg-secondary">{{ ucfirst($product->category) }}</span>
                                    </td>
                                    <td class="fw-bold text-success">₹{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                {{ $product->status === 'active' ? 'checked' : '' }}
                                                data-product-id="{{ $product->id }}">
                                            <label class="form-check-label">
                                                <span
                                                    class="badge badge-modern {{ $product->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </label>
                                        </div>
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
                                                $spiceIcons = match ($product->spice_level) {
                                                    'mild' => '🌶️',
                                                    'medium' => '🌶️🌶️',
                                                    'spicy' => '🌶️🌶️🌶️',
                                                    'very_spicy' => '🌶️🌶️🌶️🌶️',
                                                    default => '',
                                                };
                                            @endphp
                                            <span class="badge badge-modern {{ $spiceColor }}"
                                                title="{{ $spiceIcons }}">
                                                {{ ucfirst(str_replace('_', ' ', $product->spice_level)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small>
                                        <br><small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group-modern" role="group">
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                onclick="viewProduct({{ $product->id }})" title="Quick View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="deleteProduct({{ $product->id }})" title="Delete Product">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                @if ($products->hasPages())
                    <div class="d-flex justify-content-center p-4">
                        <nav>
                            <ul class="pagination pagination-modern">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-box"></i>
                    <h5>No products found</h5>
                    <p class="text-muted">Get started by creating your first momo product!</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-eye me-2"></i>Product Preview
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickViewContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchInput').on('keyup', function() {
                filterTable();
            });

            // Category filter
            $('#categoryFilter').on('change', function() {
                filterTable();
            });

            // Status filter
            $('#statusFilter').on('change', function() {
                filterTable();
            });

            // Status toggle functionality
            $('.status-toggle').on('change', function() {
                const productId = $(this).data('product-id');
                const isActive = $(this).is(':checked');
                const toggle = $(this);
                const badge = $(this).siblings('label').find('.badge');

                // Disable toggle during request
                toggle.prop('disabled', true);

                $.ajax({
                    url: `/admin/products/${productId}/toggle-status`,
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update badge
                        if (isActive) {
                            badge.removeClass('bg-warning').addClass('bg-success').text(
                                'Active');
                        } else {
                            badge.removeClass('bg-success').addClass('bg-warning').text(
                                'Inactive');
                        }

                        showSuccess('Product status updated successfully!');

                        // Trigger preview refresh
                        $(document).trigger('productUpdated');
                    },
                    error: function(xhr) {
                        // Revert toggle state
                        toggle.prop('checked', !isActive);
                        showError('Failed to update product status. Please try again.');
                    },
                    complete: function() {
                        toggle.prop('disabled', false);
                    }
                });
            });
        });

        // Filter table function
        function filterTable() {
            const searchTerm = $('#searchInput').val().toLowerCase();
            const categoryFilter = $('#categoryFilter').val();
            const statusFilter = $('#statusFilter').val();

            $('#productsTable tbody tr').each(function() {
                const row = $(this);
                const productName = row.find('td:nth-child(2)').text().toLowerCase();
                const category = row.data('category');
                const status = row.data('status');

                let showRow = true;

                // Search filter
                if (searchTerm && !productName.includes(searchTerm)) {
                    showRow = false;
                }

                // Category filter
                if (categoryFilter && category !== categoryFilter) {
                    showRow = false;
                }

                // Status filter
                if (statusFilter && status !== statusFilter) {
                    showRow = false;
                }

                if (showRow) {
                    row.show().addClass('animate__animated animate__fadeIn');
                } else {
                    row.hide();
                }
            });
        }

        // Reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#categoryFilter').val('');
            $('#statusFilter').val('');
            filterTable();
        }

        // Delete product function
        function deleteProduct(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the product!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form for deletion
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/products/${productId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = $('meta[name="csrf-token"]').attr('content');

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

        // Quick view function
        function viewProduct(productId) {
            $('#quickViewModal').modal('show');

            // Load product details via AJAX
            $.get(`/api/products/${productId}`)
                .done(function(product) {
                    const content = `
                    <div class="row">
                        <div class="col-md-6">
                            ${product.image_url ? 
                                `<img src="${product.image_url}" class="img-fluid rounded shadow" alt="${product.name}">` :
                                `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>`
                            }
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-3">${product.name}</h4>
                            <p class="text-muted">${product.description}</p>
                            
                            <div class="mb-3">
                                <strong>Price:</strong> 
                                <span class="text-success fw-bold">₹${parseFloat(product.price).toFixed(2)}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Category:</strong> 
                                <span class="badge badge-modern bg-secondary">${product.category}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Status:</strong> 
                                <span class="badge badge-modern ${product.status === 'active' ? 'bg-success' : 'bg-warning'}">
                                    ${product.status}
                                </span>
                            </div>
                            
                            ${product.spice_level ? `
                                    <div class="mb-3">
                                        <strong>Spice Level:</strong> 
                                        <span class="badge badge-modern bg-danger">${product.spice_level.replace('_', ' ')}</span>
                                    </div>
                                ` : ''}
                            
                            ${product.ingredients ? `
                                    <div class="mb-3">
                                        <strong>Ingredients:</strong> 
                                        <p class="text-muted">${product.ingredients}</p>
                                    </div>
                                ` : ''}
                            
                            <div class="mt-4">
                                <a href="/admin/products/${product.id}/edit" class="btn btn-modern-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Product
                                </a>
                            </div>
                        </div>
                    </div>
                `;

                    $('#quickViewContent').html(content);
                })
                .fail(function() {
                    $('#quickViewContent').html(`
                    <div class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Error loading product details</h5>
                        <p>Please try again later.</p>
                    </div>
                `);
                });
        }
    </script>
@endpush
