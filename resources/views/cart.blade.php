@extends('layouts.default')
@section('title', 'Ecom - Cart')
@section('content')
    <main class="container" style="max-width: 900px;">
        <section>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Shopping Cart</h1>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Continue Shopping</a>
            </div>

            @if ($cartItems->count() > 0)
                <div class="row">
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
                    @foreach ($cartItems as $items)
                        <div class="col-12">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ $items->image }}" class="img-fluid rounded-start"
                                            alt="{{ $items->title }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a
                                                    href="{{ route('products.details', $items->slug) }}">{{ $items->title }}</a>
                                            </h5>
                                            <p class="card-text">Price: {{ $items->price }} €</p>
                                            <p class="card-text">Quantity: {{ $items->quantity }}</p>
                                            <p class="card-text"><strong>Total: {{ $items->price * $items->quantity }}
                                                    €</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Total: {{ $cartItems->sum(function ($item) {return $item->price * $item->quantity;}) }}
                                    €</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('checkout.show') }}" class="btn btn-success btn-lg">Proceed to
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    {{ $cartItems->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <h3>Your cart is empty</h3>
                    <p class="text-muted">Add some products to your cart to get started!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Browse Products</a>
                </div>
            @endif
        </section>
    </main>
@endsection
