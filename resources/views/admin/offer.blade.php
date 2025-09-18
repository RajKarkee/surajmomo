@extends('admin.layout')

@section('title', 'Offers')

@section('content')
    <div class="content-wrapper">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Offer Management</h1>
            <div class="d-flex align-items-center gap-3">
                @if (!$showForm)
                    <a href="{{ route('admin.specialOffers') }}?create=1" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Offer
                    </a>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Offers</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Existing Offers List -->
        @if ($offers->count() > 0 && !$showForm)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Existing Special Offers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offers as $offerItem)
                                    <tr>
                                        <td>
                                            @if ($offerItem->image_path)
                                                <img src="{{ asset('storage/' . $offerItem->image_path) }}"
                                                    alt="{{ $offerItem->title }}" class="img-thumbnail"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px; border-radius: 8px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $offerItem->title }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($offerItem->description, 50) }}</span>
                                        </td>
                                        <td>
                                            @if ($offerItem->start_date)
                                                <small class="text-info">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $offerItem->start_date->format('M d, Y') }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($offerItem->end_date)
                                                <small class="text-warning">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    {{ $offerItem->end_date->format('M d, Y') }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($offerItem->end_date && $offerItem->end_date->isPast())
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif($offerItem->start_date && $offerItem->start_date->isFuture())
                                                <span class="badge bg-warning">Upcoming</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.specialOffers.edit', $offerItem->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit Offer">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.specialOffers.destroy', $offerItem->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this offer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Delete Offer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if ($showForm)
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>{{ isset($offer) ? 'Edit Offer' : 'Create New Offer' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($offer) ? route('admin.specialOffers.update', $offer->id) : route('admin.specialOffers.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($offer))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Offer Image Section -->
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="fas fa-image me-2"></i>Offer Image
                                    </label>
                                    <input type="file" id="image_path" name="image_path" class="dropify"
                                        data-default-file="{{ isset($offer) && $offer->image_path ? asset('storage/' . $offer->image_path) : '' }}"
                                        data-height="200" accept="image/*" />
                                </div>
                            </div>

                            <!-- Offer Title -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="title" class="form-label fw-bold text-dark">
                                        <i class="fas fa-heading me-2"></i>Offer Title
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="title" name="title"
                                        value="{{ old('title', isset($offer) ? $offer->title : '') }}"
                                        placeholder="Enter offer title" required>
                                </div>
                            </div>

                            <!-- Offer Description -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label fw-bold text-dark">
                                        <i class="fas fa-align-left me-2"></i>Offer Description
                                    </label>
                                    <textarea class="form-control form-control-lg" id="description" name="description" rows="4"
                                        placeholder="Enter detailed offer description">{{ old('description', isset($offer) ? $offer->description : '') }}</textarea>
                                </div>
                            </div>

                            <!-- Validity Period -->
                            <div class="col-12 mb-4">
                                <hr class="my-4">
                                <h5 class="text-dark mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Validity Period
                                </h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="start_date" class="form-label fw-bold text-dark">
                                        <i class="fas fa-play me-2"></i>Start Date
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="start_date"
                                        name="start_date"
                                        value="{{ old('start_date', isset($offer) ? $offer->start_date?->format('Y-m-d') : '') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="end_date" class="form-label fw-bold text-dark">
                                        <i class="fas fa-stop me-2"></i>End Date
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="end_date"
                                        name="end_date"
                                        value="{{ old('end_date', isset($offer) ? $offer->end_date?->format('Y-m-d') : '') }}"
                                        required>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.specialOffers') }}" class="btn btn-secondary btn-lg px-4">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i
                                            class="fas fa-save me-2"></i>{{ isset($offer) ? 'Update Offer' : 'Create Offer' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <style>
        .card {
            border-radius: 12px;
            border: none;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .form-label {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
        }

        .dropify-wrapper {
            border: 2px dashed #e9ecef !important;
            border-radius: 12px !important;
            transition: all 0.3s ease;
        }

        .dropify-wrapper:hover {
            border-color: #0d6efd !important;
        }

        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            border-radius: 8px;
            font-weight: 500;
        }

        hr {
            border-color: #e9ecef;
            opacity: 0.5;
        }

        input[type="date"].form-control-lg {
            cursor: pointer;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn {
            margin-right: 0.25rem;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .img-thumbnail {
            border: 2px solid #e9ecef;
            border-radius: 8px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Dropify
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop your offer image here or click to browse',
                    'replace': 'Drag and drop or click to replace image',
                    'remove': 'Remove',
                    'error': 'Oops, something went wrong.'
                },
                error: {
                    'fileSize': 'The file size is too big.',
                    'minWidth': 'The image width is too small.',
                    'maxWidth': 'The image width is too big.',
                    'minHeight': 'The image height is too small.',
                    'maxHeight': 'The image height is too big.',
                    'imageFormat': 'The image format is not allowed.'
                }
            });

            // Validate end date is after start date
            $('#start_date, #end_date').on('change', function() {
                const startDate = new Date($('#start_date').val());
                const endDate = new Date($('#end_date').val());

                if (startDate && endDate && endDate <= startDate) {
                    alert('End date must be after start date');
                    $('#end_date').val('');
                }
            });
        });
    </script>
@endpush
