@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-edit me-2"></i>
            Edit Product: {{ $product->name }}
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
                    <form action="{{ route('admin.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="steamed"
                                        {{ old('category', $product->category) === 'steamed' ? 'selected' : '' }}>Steamed
                                        Momo</option>
                                    <option value="fried"
                                        {{ old('category', $product->category) === 'fried' ? 'selected' : '' }}>Fried Momo
                                    </option>
                                    <option value="pan-fried"
                                        {{ old('category', $product->category) === 'pan-fried' ? 'selected' : '' }}>
                                        Pan-Fried Momo</option>
                                    <option value="special"
                                        {{ old('category', $product->category) === 'special' ? 'selected' : '' }}>Special
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
                                    id="price" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="spice_level" class="form-label">Spice Level</label>
                                <select class="form-select @error('spice_level') is-invalid @enderror" id="spice_level"
                                    name="spice_level">
                                    <option value="">Select Spice Level</option>
                                    <option value="mild"
                                        {{ old('spice_level', $product->spice_level) === 'mild' ? 'selected' : '' }}>Mild
                                    </option>
                                    <option value="medium"
                                        {{ old('spice_level', $product->spice_level) === 'medium' ? 'selected' : '' }}>
                                        Medium</option>
                                    <option value="spicy"
                                        {{ old('spice_level', $product->spice_level) === 'spicy' ? 'selected' : '' }}>Spicy
                                    </option>
                                    <option value="very_spicy"
                                        {{ old('spice_level', $product->spice_level) === 'very_spicy' ? 'selected' : '' }}>
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
                                rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients"
                                rows="3" placeholder="e.g., Chicken, onions, garlic, ginger, spices">{{ old('ingredients', $product->ingredients) }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                                placeholder="https://example.com/image.jpg">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($product->image_url)
                                <img id="current_image" src="{{ $product->image_url }}" class="img-thumbnail mt-2"
                                    style="max-width: 200px; max-height: 150px;" alt="Current Image">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="active"
                                    {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive"
                                    {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $product->updated_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Current Status:</strong></td>
                            <td>
                                <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="btn btn-outline-{{ $product->status === 'active' ? 'warning' : 'success' }} btn-sm w-100">
                                {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-2"></i>Delete Product
                            </button>
                        </form>
                    </div>
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
            const currentImage = document.getElementById('current_image');
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
                    if (currentImage) {
                        currentImage.style.display = 'block';
                    }
                };

                img.onload = function() {
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                };

                this.parentNode.appendChild(img);
            } else {
                if (currentImage) {
                    currentImage.style.display = 'block';
                }
            }
        });
    </script>
@endpush
