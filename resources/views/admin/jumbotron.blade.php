@extends('admin.layout')

@section('title', 'Jumbotron Management')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Jumbotron Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Jumbotron</li>
                </ol>
            </nav>
        </div>

        <!-- Add/Edit Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-image me-2"></i><span id="formTitle">Add New Jumbotron</span>
                </h5>
            </div>
            <div class="card-body">
                <form id="jumbotronForm" action="/admin/jumbotron" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="jumbotronId" name="_method" value="">

                    <div class="row">
                        <!-- Page Name -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="page" class="form-label fw-bold text-dark">
                                    <i class="fas fa-file-alt me-2"></i>Page Name
                                </label>
                                <input type="text" class="form-control form-control-lg" id="page" name="page"
                                    placeholder="e.g. home, about, contact" required>
                                <small class="text-muted">Unique identifier for the page</small>
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="title" class="form-label fw-bold text-dark">
                                    <i class="fas fa-heading me-2"></i>Title
                                </label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title"
                                    placeholder="Enter jumbotron title" required>
                            </div>
                        </div>

                        <!-- Subtitle -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="subtitle" class="form-label fw-bold text-dark">
                                    <i class="fas fa-align-left me-2"></i>Subtitle
                                </label>
                                <textarea class="form-control form-control-lg" id="subtitle" name="subtitle" rows="3"
                                    placeholder="Enter jumbotron subtitle (optional)"></textarea>
                            </div>
                        </div>

                        <!-- Background Image -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image me-2"></i>Background Image
                                </label>
                                <input type="file" id="background_image" name="background_image" class="dropify"
                                    data-default-file="" data-height="200" accept="image/*" />
                            </div>
                        </div>

                        <!-- Other Image -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-images me-2"></i>Other Image
                                </label>
                                <input type="file" id="other_image" name="other_image" class="dropify"
                                    data-default-file="" data-height="200" accept="image/*" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-secondary btn-lg px-4" onclick="resetForm()">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i><span id="submitText">Save Jumbotron</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Jumbotrons -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Existing Jumbotrons
                </h5>
            </div>
            <div class="card-body">
                @if ($jumbotrons->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Page</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Background</th>
                                    <th>Other Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jumbotrons as $jumbotron)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $jumbotron->page }}</span>
                                        </td>
                                        <td>{{ $jumbotron->title }}</td>
                                        <td>{{ Str::limit($jumbotron->subtitle, 50) }}</td>
                                        <td>
                                            @if ($jumbotron->background_image)
                                                <img src="{{ asset('storage/' . $jumbotron->background_image) }}"
                                                    alt="Background" class="img-thumbnail"
                                                    style="width: 60px; height: 40px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($jumbotron->other_image)
                                                <img src="{{ asset('storage/' . $jumbotron->other_image) }}"
                                                    alt="Other" class="img-thumbnail"
                                                    style="width: 60px; height: 40px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="editJumbotron({{ $jumbotron }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="/admin/jumbotron/{{ $jumbotron->id }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this jumbotron?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Jumbotrons Created Yet</h5>
                        <p class="text-muted">Create your first jumbotron using the form above.</p>
                    </div>
                @endif
            </div>
        </div>
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

        .table th {
            border-top: none;
            font-weight: 600;
        }

        .img-thumbnail {
            border-radius: 8px;
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
                    'default': 'Drag and drop an image here or click to browse',
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
        });

        function editJumbotron(jumbotron) {
            // Update form for editing
            document.getElementById('formTitle').textContent = 'Edit Jumbotron';
            document.getElementById('submitText').textContent = 'Update Jumbotron';
            document.getElementById('jumbotronForm').action = `/admin/jumbotron/${jumbotron.id}`;
            document.getElementById('jumbotronId').value = 'PUT';

            // Fill form fields
            document.getElementById('page').value = jumbotron.page;
            document.getElementById('title').value = jumbotron.title;
            document.getElementById('subtitle').value = jumbotron.subtitle || '';

            // Properly reinitialize Dropify with existing images
            // Background image
            const backgroundInput = $('#background_image');
            backgroundInput.dropify('destroy');
            if (jumbotron.background_image) {
                backgroundInput.attr('data-default-file', `/storage/${jumbotron.background_image}`);
            } else {
                backgroundInput.removeAttr('data-default-file');
            }
            backgroundInput.dropify({
                messages: {
                    'default': 'Drag and drop an image here or click to browse',
                    'replace': 'Drag and drop or click to replace image',
                    'remove': 'Remove',
                    'error': 'Oops, something went wrong.'
                }
            });

            // Other image
            const otherInput = $('#other_image');
            otherInput.dropify('destroy');
            if (jumbotron.other_image) {
                otherInput.attr('data-default-file', `/storage/${jumbotron.other_image}`);
            } else {
                otherInput.removeAttr('data-default-file');
            }
            otherInput.dropify({
                messages: {
                    'default': 'Drag and drop an image here or click to browse',
                    'replace': 'Drag and drop or click to replace image',
                    'remove': 'Remove',
                    'error': 'Oops, something went wrong.'
                }
            });

            // Scroll to form
            document.querySelector('.card').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function resetForm() {
            // Reset form to add mode
            document.getElementById('formTitle').textContent = 'Add New Jumbotron';
            document.getElementById('submitText').textContent = 'Save Jumbotron';
            document.getElementById('jumbotronForm').action = '/admin/jumbotron';
            document.getElementById('jumbotronId').value = '';

            // Clear form
            document.getElementById('jumbotronForm').reset();

            // Reset Dropify properly
            $('.dropify').each(function() {
                const $this = $(this);
                $this.dropify('destroy');
                $this.removeAttr('data-default-file');
                $this.dropify({
                    messages: {
                        'default': 'Drag and drop an image here or click to browse',
                        'replace': 'Drag and drop or click to replace image',
                        'remove': 'Remove',
                        'error': 'Oops, something went wrong.'
                    }
                });
            });
        }
    </script>
@endpush
