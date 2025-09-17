@extends('admin.layout')

@section('title', 'Why Choose Us Management')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Why Choose Us Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Why Choose Us</li>
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

        <!-- Add New Item Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>Add New Reason
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.why_choose_us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="title" class="form-label fw-bold text-dark">
                                    <i class="fas fa-heading me-2"></i>Title *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title"
                                    value="{{ old('title') }}" required placeholder="e.g., Premium Quality Ingredients">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="tagline" class="form-label fw-bold text-dark">
                                    <i class="fas fa-tag me-2"></i>Tagline
                                </label>
                                <input type="text" class="form-control form-control-lg" id="tagline" name="tagline"
                                    value="{{ old('tagline') }}" placeholder="e.g., 100% Fresh & Natural">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label fw-bold text-dark">
                                    <i class="fas fa-align-left me-2"></i>Description *
                                </label>
                                <textarea class="form-control" id="description" name="description" rows="4" required
                                    placeholder="Describe why customers should choose you...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image me-2"></i>Image
                                </label>
                                <input type="file" name="image" class="dropify" data-height="200" accept="image/*" />
                                <small class="text-muted">Recommended size: 400x300px</small>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex align-items-end mb-3">
                            <div class="form-group w-100">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-plus me-2"></i>Add Reason
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Items -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Current Reasons ({{ $items->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if ($items->count() > 0)
                    @foreach ($items as $index => $item)
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-star text-warning me-2"></i>
                                        Reason #{{ $index + 1 }}: {{ $item->title }}
                                    </h6>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary btn-sm toggle-edit"
                                            data-item-id="{{ $item->id }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <form action="{{ route('admin.why_choose_us.destroy', $item->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this reason?')">
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
                                <div class="view-mode-{{ $item->id }}">
                                    <div class="row">
                                        @if ($item->image)
                                            <div class="col-md-4 mb-3">
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->title }}" class="img-fluid rounded shadow-sm"
                                                    style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                        @endif

                                        <div class="{{ $item->image ? 'col-md-8' : 'col-md-12' }}">
                                            @if ($item->tagline)
                                                <div class="mb-2">
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-tag me-1"></i>{{ $item->tagline }}
                                                    </span>
                                                </div>
                                            @endif

                                            <p class="lead mb-3">{{ $item->description }}</p>

                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Created: {{ $item->created_at->format('M d, Y h:i A') }}
                                                @if ($item->updated_at != $item->created_at)
                                                    | Updated: {{ $item->updated_at->format('M d, Y h:i A') }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Mode (Initially Hidden) -->
                                <div class="edit-mode-{{ $item->id }}" style="display: none;">
                                    <form action="{{ route('admin.why_choose_us.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-heading me-2"></i>Title *
                                                </label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ $item->title }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-tag me-2"></i>Tagline
                                                </label>
                                                <input type="text" class="form-control" name="tagline"
                                                    value="{{ $item->tagline }}">
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-align-left me-2"></i>Description *
                                                </label>
                                                <textarea class="form-control" name="description" rows="4" required>{{ $item->description }}</textarea>
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label class="form-label fw-bold text-dark">
                                                    <i class="fas fa-image me-2"></i>Image
                                                </label>
                                                <input type="file" name="image" class="dropify"
                                                    data-default-file="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
                                                    data-height="150" accept="image/*" />
                                                <small class="text-muted">Leave empty to keep current image</small>
                                            </div>

                                            <div class="col-md-4 d-flex align-items-end mb-3">
                                                <div class="d-grid gap-2 w-100">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i>Update
                                                    </button>
                                                    <button type="button" class="btn btn-secondary cancel-edit"
                                                        data-item-id="{{ $item->id }}">
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
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No reasons added yet</h5>
                        <p class="text-muted">Add your first reason using the form above</p>
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
                    const title = $(this).find('input[name="title"]').val().trim();
                    const description = $(this).find('textarea[name="description"]').val().trim();

                    if (!title || !description) {
                        e.preventDefault();
                        alert('Please fill in all required fields (Title and Description)');
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
