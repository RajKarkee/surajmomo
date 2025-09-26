@extends('admin.layout')
@section('title', 'Add Home Setting')
@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Add Home Setting</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.home_settings') }}">Home Settings</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.home_settings.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="item" class="form-label">Item</label>
                        <select id="item" name="item" class="form-control">
                            <option value="product">Product</option>
                            <option value="why_choose_us">Why Choose Us</option>
                        </select>
                    </div>

                    <div class="mb-3" id="productSelect">
                        <label for="product_id" class="form-label">Select Product</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="whySelect" style="display:none;">
                        <label for="why_choose_us" class="form-label">Select Why Choose Us</label>
                        <select id="why_choose_us" name="why_choose_us" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach ($why as $w)
                                <option value="{{ $w->id }}">{{ $w->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" value="0">
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
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
