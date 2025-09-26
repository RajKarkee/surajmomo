@extends('admin.layout')
@section('title', 'Edit Home Setting')
@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Edit Home Setting</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.home_settings') }}">Home Settings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.home_settings.update', $hc->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="item" class="form-label">Item</label>
                        <select id="item" name="item" class="form-control">
                            <option value="product" {{ $hc->item === 'product' ? 'selected' : '' }}>Product</option>
                            <option value="why_choose_us" {{ $hc->item === 'why_choose_us' ? 'selected' : '' }}>Why Choose
                                Us</option>
                        </select>
                    </div>

                    <div class="mb-3" id="productSelect">
                        <label for="product_id" class="form-label">Select Product</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" {{ $hc->product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="whySelect" style="display:none;">
                        <label for="why_choose_us" class="form-label">Select Why Choose Us</label>
                        <select id="why_choose_us" name="why_choose_us" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach ($why as $w)
                                <option value="{{ $w->id }}" {{ $hc->why_choose_us == $w->id ? 'selected' : '' }}>
                                    {{ $w->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const item = document.getElementById('item');
            const productSelect = document.getElementById('productSelect');
            const whySelect = document.getElementById('whySelect');

            function toggle() {
                if (item.value === 'product') {
                    productSelect.style.display = '';
                    whySelect.style.display = 'none';
                } else {
                    productSelect.style.display = 'none';
                    whySelect.style.display = '';
                }
            }

            item.addEventListener('change', toggle);
            toggle();
        });
    </script>

@endsection
