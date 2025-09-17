@extends('admin.layout')

@section('title', 'Customer Testimonials Management')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Customer Testimonials Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customer Testimonials</li>
                </ol>
            </nav>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Add New Testimonial Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>Add New Testimonial
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customer_testimonials.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="customer_name" class="form-label fw-bold text-dark">
                                    <i class="fas fa-user me-2"></i>Customer Name *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="customer_name"
                                    name="customer_name" value="{{ old('customer_name') }}" required
                                    placeholder="e.g., John Doe">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="customer_work" class="form-label fw-bold text-dark">
                                    <i class="fas fa-briefcase me-2"></i>Customer Work/Title
                                </label>
                                <input type="text" class="form-control form-control-lg" id="customer_work"
                                    name="customer_work" value="{{ old('customer_work') }}"
                                    placeholder="e.g., CEO at ABC Company">
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label for="feedback" class="form-label fw-bold text-dark">
                                    <i class="fas fa-quote-left me-2"></i>Customer Feedback *
                                </label>
                                <textarea class="form-control" id="feedback" name="feedback" rows="4" required
                                    placeholder="Share what the customer said about your service...">{{ old('feedback') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="rating" class="form-label fw-bold text-dark">
                                    <i class="fas fa-star me-2"></i>Rating (1-5)
                                </label>
                                <select class="form-control form-control-lg" id="rating" name="rating">
                                    <option value="">Select Rating</option>
                                    <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)
                                    </option>
                                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)
                                    </option>
                                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)
                                    </option>
                                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 Stars)
                                    </option>
                                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1 Star)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-camera me-2"></i>Customer Photo
                                </label>
                                <input type="file" name="customer_image" class="dropify" data-height="200"
                                    accept="image/*" />
                                <small class="text-muted">Recommended size: 300x300px (Square)</small>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex align-items-end mb-3">
                            <div class="form-group w-100">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-plus me-2"></i>Add Testimonial
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Testimonials -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-comments me-2"></i>Customer Testimonials ({{ $testimonials->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if ($testimonials->count() > 0)
                    @foreach ($testimonials as $index => $testimonial)
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user-circle text-info me-2"></i>
                                        {{ $testimonial->customer_name }}
                                        @if ($testimonial->customer_work)
                                            <small class="text-muted">- {{ $testimonial->customer_work }}</small>
                                        @endif
                                    </h6>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary btn-sm toggle-edit"
                                            data-item-id="{{ $testimonial->id }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <form
                                            action="{{ route('admin.customer_testimonials.destroy', $testimonial->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Display Mode -->
                                <div class="view-mode-{{ $testimonial->id }}">
                                    <div class="row">
                                        @if ($testimonial->customer_image)
                                            <div class="col-md-3 mb-3 text-center">
                                                <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                                    alt="{{ $testimonial->customer_name }}"
                                                    class="img-fluid rounded-circle shadow-sm"
                                                    style="max-height: 150px; width: 150px; object-fit: cover;">
                                            </div>
                                        @endif

                                        <div class="{{ $testimonial->customer_image ? 'col-md-9' : 'col-md-12' }}">
                                            @if ($testimonial->rating)
                                                <div class="mb-2">
                                                    <span class="text-warning fs-5">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $testimonial->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <span class="ms-2 text-muted">({{ $testimonial->rating }}/5)</span>
                                                </div>
                                            @endif

                                            <blockquote class="blockquote mb-3">
                                                <p class="mb-0 fst-italic">"{{ $testimonial->feedback }}"</p>
                                            </blockquote>

                                            <div class="d-flex align-items-center">
                                                <strong class="me-2">{{ $testimonial->customer_name }}</strong>
                                                @if ($testimonial->customer_work)
                                                    <span
                                                        class="badge bg-secondary">{{ $testimonial->customer_work }}</span>
                                                @endif
                                            </div>

                                            <small class="text-muted mt-2 d-block">
                                                <i class="fas fa-calendar me-1"></i>
                                                Added: {{ $testimonial->created_at->format('M d, Y h:i A') }}
                                                @if ($testimonial->updated_at != $testimonial->created_at)
                                                    | Updated: {{ $testimonial->updated_at->format('M d, Y h:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Mode (Initially Hidden) -->
                                <div class="edit-mode-{{ $testimonial->id }}" style="display: none;">
                                    <form action="{{ route('admin.customer_testimonials.update', $testimonial->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-user me-2"></i>Customer Name *
                                                </label>
                                                <input type="text" class="form-control" name="customer_name"
                                                    value="{{ $testimonial->customer_name }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-briefcase me-2"></i>Customer Work/Title
                                                </label>
                                                <input type="text" class="form-control" name="customer_work"
                                                    value="{{ $testimonial->customer_work }}">
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-quote-left me-2"></i>Customer Feedback *
                                                </label>
                                                <textarea class="form-control" name="feedback" rows="4" required>{{ $testimonial->feedback }}</textarea>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-star me-2"></i>Rating (1-5)
                                                </label>
                                                <select class="form-control" name="rating">
                                                    <option value="">Select Rating</option>
                                                    <option value="5"
                                                        {{ $testimonial->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)
                                                    </option>
                                                    <option value="4"
                                                        {{ $testimonial->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)
                                                    </option>
                                                    <option value="3"
                                                        {{ $testimonial->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)
                                                    </option>
                                                    <option value="2"
                                                        {{ $testimonial->rating == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars)
                                                    </option>
                                                    <option value="1"
                                                        {{ $testimonial->rating == 1 ? 'selected' : '' }}>⭐ (1 Star)
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-camera me-2"></i>Customer Photo
                                                </label>
                                                <input type="file" name="customer_image" class="dropify"
                                                    data-default-file="{{ $testimonial->customer_image ? asset('storage/' . $testimonial->customer_image) : '' }}"
                                                    data-height="150" accept="image/*" />
                                                <small class="text-muted">Leave empty to keep current photo</small>
                                            </div>

                                            <div class="col-md-4 d-flex align-items-end mb-3">
                                                <div class="d-grid gap-2 w-100">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i>Update
                                                    </button>
                                                    <button type="button" class="btn btn-secondary cancel-edit"
                                                        data-item-id="{{ $testimonial->id }}">
                                                        <i class="fas fa-times me-2"></i>Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No testimonials added yet</h5>
                        <p class="text-muted">Add your first customer testimonial using the form above</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Dropify
                $('.dropify').dropify({
                    messages: {
                        'default': 'Drag and drop a file here or click',
                        'replace': 'Drag and drop or click to replace',
                        'remove': 'Remove',
                        'error': 'Ooops, something wrong happened.'
                    }
                });

                // Toggle edit mode
                $('.toggle-edit').click(function() {
                    const itemId = $(this).data('item-id');
                    $('.view-mode-' + itemId).hide();
                    $('.edit-mode-' + itemId).show();
                    $(this).closest('.card').find('.btn-group').hide();

                    // Reinitialize Dropify for the edit form
                    $('.edit-mode-' + itemId + ' .dropify').dropify({
                        messages: {
                            'default': 'Drag and drop a file here or click',
                            'replace': 'Drag and drop or click to replace',
                            'remove': 'Remove',
                            'error': 'Ooops, something wrong happened.'
                        }
                    });
                });

                // Cancel edit mode
                $('.cancel-edit').click(function() {
                    const itemId = $(this).data('item-id');
                    $('.edit-mode-' + itemId).hide();
                    $('.view-mode-' + itemId).show();
                    $(this).closest('.card').find('.btn-group').show();
                });

                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 5000);

                // Form validation
                $('form').on('submit', function(e) {
                    const customerName = $(this).find('input[name="customer_name"]').val().trim();
                    const feedback = $(this).find('textarea[name="feedback"]').val().trim();

                    if (!customerName || !feedback) {
                        e.preventDefault();
                        alert('Please fill in all required fields (Customer Name and Feedback)');
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
