@extends('admin.layout')
@section('title', 'Home Settings')
@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Home Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Home Settings</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group" role="group" aria-label="home-control-buttons">
                <button id="btnProducts" class="btn btn-outline-primary">Products</button>
                <button id="btnWhyChoose" class="btn btn-outline-secondary">Why Choose Update</button>
            </div>

            <a href="{{ route('admin.home_settings.add') }}" class="btn btn-primary">Add Home Setting</a>
        </div>

        {{-- Products table (hidden by default) --}}
        <div id="productsTable" class="mb-4" style="display:none;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Home Control: Product entries</h5>
                    <div class="table-responsive">
                        <table id="dtProducts" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Product</th>
                                    <th>Why Choose Us</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Why Choose Us table (hidden by default) --}}
        <div id="whyChooseTable" class="mb-4" style="display:none;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Home Control: Why Choose Us entries</h5>
                    <div class="table-responsive">
                        <table id="dtWhy" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Product</th>
                                    <th>Why Choose Us</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnProducts = document.getElementById('btnProducts');
            const btnWhy = document.getElementById('btnWhyChoose');
            const productsTable = document.getElementById('productsTable');
            const whyTable = document.getElementById('whyChooseTable');

            btnProducts.addEventListener('click', function() {
                const show = productsTable.style.display === 'none';
                productsTable.style.display = show ? 'block' : 'none';
                if (show) whyTable.style.display = 'none';
            });

            btnWhy.addEventListener('click', function() {
                const show = whyTable.style.display === 'none';
                whyTable.style.display = show ? 'block' : 'none';
                if (show) productsTable.style.display = 'none';
            });
        });
    </script>

    {{-- DataTables assets (CDN) and init --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            let dtProducts = $('#dtProducts').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.home_settings.data') }}',
                    data: function(d) {
                        d.type = 'product';
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'item'
                    },
                    {
                        data: 'product_name',
                        defaultContent: ''
                    },
                    {
                        data: 'why_title',
                        defaultContent: ''
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<a href="/admin/home_settings/${data.id}/edit" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                <button class="btn btn-sm btn-outline-danger btn-delete-trigger" data-id="${data.id}">Delete</button>`;
                        }
                    }
                ]
            });

            let dtWhy = $('#dtWhy').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.home_settings.data') }}',
                    data: function(d) {
                        d.type = 'why';
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'item'
                    },
                    {
                        data: 'product_name',
                        defaultContent: ''
                    },
                    {
                        data: 'why_title',
                        defaultContent: ''
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<a href="/admin/home_settings/${data.id}/edit" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                <button class="btn btn-sm btn-outline-danger btn-delete-trigger" data-id="${data.id}">Delete</button>`;
                        }
                    }
                ]
            });

            // Open modal when delete triggered
            $(document).on('click', '.btn-delete-trigger', function() {
                const id = $(this).data('id');
                $('#deleteModal').data('id', id).modal('show');
            });

            // Confirm delete in modal
            $('#confirmDeleteBtn').on('click', function() {
                const id = $('#deleteModal').data('id');
                if (!id) return;
                const btn = $(this);
                btn.prop('disabled', true).text('Deleting...');
                $.ajax({
                    url: `/admin/home_settings/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function() {
                    dtProducts.ajax.reload(null, false);
                    dtWhy.ajax.reload(null, false);
                    $('#deleteModal').modal('hide');
                }).fail(function() {
                    alert('Delete failed');
                }).always(function() {
                    btn.prop('disabled', false).text('Delete');
                });
            });
        });
    </script>

@endsection

{{-- Delete confirmation modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this entry? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
