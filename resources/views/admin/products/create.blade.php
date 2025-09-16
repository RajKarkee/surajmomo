@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-plus me-2"></i>
            Create New Product
        </h1>
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="steamed" {{ old('category') === 'steamed' ? 'selected' : '' }}>Steamed
                                        Momo</option>
                                    <option value="fried" {{ old('category') === 'fried' ? 'selected' : '' }}>Fried Momo
                                    </option>
                                    <option value="pan-fried" {{ old('category') === 'pan-fried' ? 'selected' : '' }}>
                                        Pan-Fried Momo</option>
                                    <option value="special" {{ old('category') === 'special' ? 'selected' : '' }}>Special
                                        Momo</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (₹) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                    required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="spice_level" class="form-label">Spice Level</label>
                                <select class="form-select @error('spice_level') is-invalid @enderror" id="spice_level"
                                    name="spice_level">
                                    <option value="">Select Spice Level</option>
                                    <option value="mild" {{ old('spice_level') === 'mild' ? 'selected' : '' }}>Mild
                                    </option>
                                    <option value="medium" {{ old('spice_level') === 'medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="spicy" {{ old('spice_level') === 'spicy' ? 'selected' : '' }}>Spicy
                                    </option>
                                    <option value="very_spicy" {{ old('spice_level') === 'very_spicy' ? 'selected' : '' }}>
                                        Very Spicy</option>
                                </select>
                                @error('spice_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients"
                                rows="3" placeholder="e.g., Chicken, onions, garlic, ginger, spices">{{ old('ingredients') }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                id="image_url" name="image_url" value="{{ old('image_url') }}"
                                placeholder="https://example.com/image.jpg">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            <strong>Name:</strong> Use descriptive names like "Chicken Steamed Momo"
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            <strong>Description:</strong> Include taste, texture, and serving size
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            <strong>Price:</strong> Consider portion size and competition
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            <strong>Images:</strong> Use high-quality food photos for better appeal
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image URL preview
        document.getElementById('image_url').addEventListener('input', function() {
            const url = this.value;
            const preview = document.getElementById('image_preview');

            if (preview) {
                preview.remove();
            }

            if (url) {
                const img = document.createElement('img');
                img.id = 'image_preview';
                img.src = url;
                img.className = 'img-thumbnail mt-2';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '150px';

                img.onerror = function() {
                    this.remove();
                };

                this.parentNode.appendChild(img);
            }
        });
    </script>
@endpush
