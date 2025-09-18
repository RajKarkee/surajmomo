@extends('admin.layout')

@section('title', 'Settings')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Site Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>System Configuration
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Logo Upload Section -->
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image me-2"></i>Site Logo
                                </label>
                                <input type="file" id="logo_path" name="logo_path" class="dropify"
                                    data-default-file="{{ $settings->logo_path ? asset('storage/' . $settings->logo_path) : '' }}"
                                    data-height="200" accept="image/*" />
                            </div>
                        </div>

                        <!-- Basic Information Section -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="site_name" class="form-label fw-bold text-dark">
                                    <i class="fas fa-globe me-2"></i>Site Name
                                </label>
                                <input type="text" class="form-control form-control-lg" id="site_name" name="site_name"
                                    value="{{ old('site_name', $settings->site_name) }}" placeholder="Enter site name">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="contact_email" class="form-label fw-bold text-dark">
                                    <i class="fas fa-envelope me-2"></i>Contact Email
                                </label>
                                <input type="email" class="form-control form-control-lg" id="contact_email"
                                    name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}"
                                    placeholder="Enter contact email">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="contact_phone" class="form-label fw-bold text-dark">
                                    <i class="fas fa-phone me-2"></i>Contact Phone
                                </label>
                                <input type="text" class="form-control form-control-lg" id="contact_phone"
                                    name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}"
                                    placeholder="Enter contact phone">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="time" class="form-label fw-bold text-dark">
                                    <i class="fas fa-clock me-2"></i>Business Hours
                                </label>
                                <input type="text" class="form-control form-control-lg" id="time" name="time"
                                    value="{{ old('time', $settings->time) }}" placeholder="e.g. 10:00 AM - 8:00 PM">
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="facebook_link" class="form-label fw-bold text-dark">
                                    <i class="fab fa-facebook me-2 text-primary"></i>Facebook URL
                                </label>
                                <input type="url" class="form-control form-control-lg" id="facebook_link"
                                    name="facebook_link" value="{{ old('facebook_link', $settings->facebook_link) }}"
                                    placeholder="Facebook page URL">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="twitter_link" class="form-label fw-bold text-dark">
                                    <i class="fab fa-twitter me-2 text-info"></i>Twitter URL
                                </label>
                                <input type="url" class="form-control form-control-lg" id="twitter_link"
                                    name="twitter_link" value="{{ old('twitter_link', $settings->twitter_link) }}"
                                    placeholder="Twitter profile URL">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="instagram_link" class="form-label fw-bold text-dark">
                                    <i class="fab fa-instagram me-2 text-danger"></i>Instagram URL
                                </label>
                                <input type="url" class="form-control form-control-lg" id="instagram_link"
                                    name="instagram_link" value="{{ old('instagram_link', $settings->instagram_link) }}"
                                    placeholder="Instagram profile URL">
                            </div>
                        </div>

                        <!-- Color Scheme Section -->
                        <div class="col-12 mb-4">
                            <hr class="my-4">
                            <h5 class="text-dark mb-3">
                                <i class="fas fa-palette me-2"></i>Color Scheme Configuration
                            </h5>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="primary_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('primary_color', $settings->primary_color ?? '#0d6efd') }}"></i>Primary
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker"
                                    id="primary_color" name="primary_color"
                                    value="{{ old('primary_color', $settings->primary_color ?? '#0d6efd') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="secondary_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('secondary_color', $settings->secondary_color ?? '#6c757d') }}"></i>Secondary
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker"
                                    id="secondary_color" name="secondary_color"
                                    value="{{ old('secondary_color', $settings->secondary_color ?? '#6c757d') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="accent_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('accent_color', $settings->accent_color ?? '#ffc107') }}"></i>Accent
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker" id="accent_color"
                                    name="accent_color"
                                    value="{{ old('accent_color', $settings->accent_color ?? '#ffc107') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="dark_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('dark_color', $settings->dark_color ?? '#212529') }}"></i>Dark
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker" id="dark_color"
                                    name="dark_color"
                                    value="{{ old('dark_color', $settings->dark_color ?? '#212529') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="light_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('light_color', $settings->light_color ?? '#f8f9fa') }}"></i>Light
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker" id="light_color"
                                    name="light_color"
                                    value="{{ old('light_color', $settings->light_color ?? '#f8f9fa') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="white_color" class="form-label fw-bold text-dark">
                                    <i class="fas fa-circle me-2"
                                        style="color: {{ old('white_color', $settings->white_color ?? '#ffffff') }}"></i>White
                                    Color
                                </label>
                                <input type="color" class="form-control form-control-lg color-picker" id="white_color"
                                    name="white_color"
                                    value="{{ old('white_color', $settings->white_color ?? '#ffffff') }}">
                            </div>
                        </div>

                        <!-- Address and Map Section -->
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label for="address" class="form-label fw-bold text-dark">
                                    <i class="fas fa-map-marker-alt me-2"></i>Business Address
                                </label>
                                <textarea class="form-control form-control-lg" id="address" name="address" rows="3"
                                    placeholder="Enter complete business address">{{ old('address', $settings->address) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="map_link" class="form-label fw-bold text-dark">
                                    <i class="fas fa-map me-2"></i>Google Maps Link
                                </label>
                                <input type="url" class="form-control form-control-lg" id="map_link"
                                    name="map_link" value="{{ old('map_link', $settings->map_link) }}"
                                    placeholder="Google Maps URL">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-secondary btn-lg px-4">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Save Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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

        .color-picker {
            height: 50px !important;
            border-radius: 8px !important;
            cursor: pointer;
            padding: 0.25rem !important;
        }

        .color-picker::-webkit-color-swatch-wrapper {
            padding: 0;
            border-radius: 6px;
        }

        .color-picker::-webkit-color-swatch {
            border: none;
            border-radius: 6px;
        }

        .color-picker::-moz-color-swatch {
            border: none;
            border-radius: 6px;
        }

        hr {
            border-color: #e9ecef;
            opacity: 0.5;
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
                    'default': 'Drag and drop your logo here or click to browse',
                    'replace': 'Drag and drop or click to replace logo',
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

            // Color picker change event
            $('.color-picker').on('change', function() {
                const colorValue = $(this).val();
                const iconElement = $(this).closest('.form-group').find('label i.fa-circle');
                iconElement.css('color', colorValue);
            });
        });
    </script>
@endpush
