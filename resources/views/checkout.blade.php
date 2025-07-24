@extends('layouts.default')
@section('title', 'Ecom - Checkout')
@section('content')
    <main class="container" style="max-width: 900px;">
        <section>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Checkout</h2>
                <a href="{{ route('cart.show') }}" class="btn btn-outline-secondary">← Back to Cart</a>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('checkout.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <button type="submit" class="btn btn-success btn-lg">Proceed to Payment</button>
            </form>
        </section>
    </main>
@endsection
