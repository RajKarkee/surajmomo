@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="my-4">Order Confirmation</h1>
        <p class="lead">Thank you for your order!</p>
        <p>Your order has been successfully placed and will be processed shortly.</p>
        <div id="orderSummary" class="mb-3"></div>
        <h3>Total: Rs. <span id="orderTotal">0</span></h3>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
