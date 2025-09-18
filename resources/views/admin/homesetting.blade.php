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
    </div>
@endsection
