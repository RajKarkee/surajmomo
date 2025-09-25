@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('content')
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2"
                style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="fas fa-plus me-2"></i>Create New Product
            </h2>
            <p class="text-muted mb-0">Add a new delicious momo to your menu</p>
        </div>
        <div>
            <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Product Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" class="form-modern" id="productForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>Product Name <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="e.g., Chicken Steamed Momo">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="category" class="form-label">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>Category <span
                                        class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="steamed" {{ old('category') === 'steamed' ? 'selected' : '' }}>🥟 Steamed
                                        Momo</option>
                                    <option value="fried" {{ old('category') === 'fried' ? 'selected' : '' }}>🍤 Fried Momo
                                    </option>
                                    <option value="pan-fried" {{ old('category') === 'pan-fried' ? 'selected' : '' }}>🥘
                                        Pan-Fried Momo</option>
                                    <option value="special" {{ old('category') === 'special' ? 'selected' : '' }}>⭐ Special
                                        Momo</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label">
                                    <i class="fas fa-rupee-sign me-2 text-success"></i>Price (₹) <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">₹</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price') }}" step="0.01"
                                        min="0" required placeholder="250.00">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="spice_level" class="form-label">
                                    <i class="fas fa-pepper-hot me-2 text-danger"></i>Spice Level
                                </label>
                                <select class="form-select @error('spice_level') is-invalid @enderror" id="spice_level"
                                    name="spice_level">
                                    <option value="">Select Spice Level</option>
                                    <option value="mild" {{ old('spice_level') === 'mild' ? 'selected' : '' }}>🌶️ Mild
                                    </option>
                                    <option value="medium" {{ old('spice_level') === 'medium' ? 'selected' : '' }}>🌶️🌶️
                                        Medium</option>
                                    <option value="spicy" {{ old('spice_level') === 'spicy' ? 'selected' : '' }}>🌶️🌶️🌶️
                                        Spicy</option>
                                    <option value="very_spicy" {{ old('spice_level') === 'very_spicy' ? 'selected' : '' }}>
                                        🌶️🌶️🌶️🌶️ Very Spicy</option>
                                </select>
                                @error('spice_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-2 text-primary"></i>Description <span
                                    class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" required placeholder="Describe the taste, ingredients, and what makes this momo special...">{{ old('description') }}</textarea>
                            <div class="form-text">
                                <span id="descriptionCount">0</span>/500 characters
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ingredients" class="form-label">
                                <i class="fas fa-leaf me-2 text-success"></i>Ingredients
                            </label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients"
                                rows="3" placeholder="e.g., Chicken, onions, garlic, ginger, cilantro, traditional spices">{{ old('ingredients') }}</textarea>
                            <div class="form-text">List the main ingredients separated by commas</div>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image_url" class="form-label">
                                <i class="fas fa-image me-2 text-info"></i>Image URL
                            </label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                id="image_url" name="image_url" value="{{ old('image_url') }}"
                                placeholder="https://example.com/momo-image.jpg">
                            <div class="form-text">Provide a direct link to a high-quality image of your momo</div>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreviewContainer" class="mt-3" style="display: none;">
                                <img id="imagePreview" class="image-preview" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on me-2 text-warning"></i>Status <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="statusActive"
                                            value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusActive">
                                            <span class="badge badge-modern bg-success">Active</span>
                                            <small class="d-block text-muted">Visible to customers</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="statusInactive" value="inactive"
                                            {{ old('status') === 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusInactive">
                                            <span class="badge badge-modern bg-warning">Inactive</span>
                                            <small class="d-block text-muted">Hidden from customers</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                placeholder="0 for highest priority">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="button" class="btn btn-outline-info" id="previewBtn">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                            <button type="submit" class="btn btn-modern-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="modern-card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-lightbulb me-2"></i>Tips for Great Products
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Name:</strong> Use descriptive names like "Chicken Steamed Momo with Herbs"
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Description:</strong> Mention taste, texture, serving size, and uniqueness
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Price:</strong> Consider portion size, ingredients cost, and competition
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Images:</strong> Use high-quality, well-lit photos showing the actual product
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Ingredients:</strong> List allergens and highlight special ingredients
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Live Preview Card -->
            <div class="modern-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-eye me-2"></i>Live Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div id="livePreview" class="text-center text-muted">
                        <i class="fas fa-image fa-3x mb-3 opacity-50"></i>
                        <p>Fill in the form to see a preview of how your product will appear to customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="fullPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-eye me-2"></i>Product Preview
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="fullPreviewContent">
                    <!-- Preview content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-modern-primary" onclick="$('#productForm').submit()">
                        <i class="fas fa-save me-2"></i>Create Product
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Character count for description
            $('#description').on('input', function() {
                const length = $(this).val().length;
                $('#descriptionCount').text(length);

                if (length > 500) {
                    $(this).addClass('is-invalid');
                    $('#descriptionCount').addClass('text-danger');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#descriptionCount').removeClass('text-danger');
                }
            });

            // Image preview
            $('#image_url').on('input', function() {
                const url = $(this).val();
                const container = $('#imagePreviewContainer');
                const preview = $('#imagePreview');

                if (url) {
                    preview.attr('src', url);
                    preview.on('load', function() {
                        container.show().addClass('animate__animated animate__fadeIn');
                    });
                    preview.on('error', function() {
                        container.hide();
                    });
                } else {
                    container.hide();
                }

                updateLivePreview();
            });

            // Live preview updates
            $('#name, #description, #price, #category, #spice_level, #ingredients').on('input change', function() {
                updateLivePreview();
            });

            // Status change
            $('input[name="status"]').on('change', function() {
                updateLivePreview();
            });

            // Full preview button
            $('#previewBtn').on('click', function() {
                updateFullPreview();
                $('#fullPreviewModal').modal('show');
            });

            // Form submission with loading state
            $('#productForm').on('submit', function() {
                const submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true).addClass('btn-loading');
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Creating...');
            });

            // Initialize preview
            updateLivePreview();
        });

        function updateLivePreview() {
            const name = $('#name').val() || 'Product Name';
            const description = $('#description').val() || 'Product description will appear here...';
            const price = $('#price').val() || '0.00';
            const category = $('#category option:selected').text() || 'Category';
            const spiceLevel = $('#spice_level option:selected').text() || '';
            const imageUrl = $('#image_url').val();
            const status = $('input[name="status"]:checked').val() || 'active';

            const previewHtml = `
            <div class="card border-0 shadow-sm">
                ${imageUrl ? 
                    `<img src="${imageUrl}" class="card-img-top" style="height: 200px; object-fit: cover;" onerror="this.style.display='none'">` :
                    `<div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>`
                }
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0">${name}</h6>
                        <span class="badge ${status === 'active' ? 'bg-success' : 'bg-warning'}">${status}</span>
                    </div>
                    <p class="card-text text-muted small">${description.substring(0, 100)}${description.length > 100 ? '...' : ''}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="h6 text-success mb-0">₹${parseFloat(price || 0).toFixed(2)}</span>
                            <br><small class="text-muted">${category}</small>
                        </div>
                        ${spiceLevel ? `<span class="badge bg-danger">${spiceLevel}</span>` : ''}
                    </div>
                </div>
            </div>
        `;

            $('#livePreview').html(previewHtml);
        }

        function updateFullPreview() {
            const formData = {
                name: $('#name').val() || 'Untitled Product',
                description: $('#description').val() || 'No description provided',
                price: $('#price').val() || '0.00',
                category: $('#category option:selected').text() || 'No category',
                spice_level: $('#spice_level option:selected').text() || 'Not specified',
                ingredients: $('#ingredients').val() || 'Not specified',
                image_url: $('#image_url').val(),
                status: $('input[name="status"]:checked').val() || 'active'
            };

            const fullPreviewHtml = `
            <div class="row">
                <div class="col-md-6">
                    ${formData.image_url ? 
                        `<img src="${formData.image_url}" class="img-fluid rounded shadow" style="max-height: 400px; width: 100%; object-fit: cover;">` :
                        `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <div class="text-center">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No image provided</p>
                                        </div>
                                    </div>`
                    }
                </div>
                <div class="col-md-6">
                    <h3 class="mb-3">${formData.name}</h3>
                    <p class="text-muted">${formData.description}</p>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Price:</strong>
                            <div class="h5 text-success">₹${parseFloat(formData.price).toFixed(2)}</div>
                        </div>
                        <div class="col-6">
                            <strong>Status:</strong>
                            <div><span class="badge badge-modern ${formData.status === 'active' ? 'bg-success' : 'bg-warning'}">${formData.status}</span></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Category:</strong> <span class="badge badge-modern bg-secondary">${formData.category}</span>
                    </div>
                    
                    ${formData.spice_level !== 'Not specified' ? `
                                    <div class="mb-3">
                                        <strong>Spice Level:</strong> <span class="badge badge-modern bg-danger">${formData.spice_level}</span>
                                    </div>
                                ` : ''}
                    
                    ${formData.ingredients !== 'Not specified' ? `
                                    <div class="mb-3">
                                        <strong>Ingredients:</strong>
                                        <p class="text-muted">${formData.ingredients}</p>
                                    </div>
                                ` : ''}
                </div>
            </div>
        `;

            $('#fullPreviewContent').html(fullPreviewHtml);
        }
    </script>
@endpush
