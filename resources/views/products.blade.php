@extends('layouts.default')
@section('title', 'Ecom - Products')
@section('content')
    <main class="container" style="max-width: 900px;">
        <section>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card p-2 shadow-sm">
                            <img src="{{ $product->image }}" alt="{{ $product->title }}" width="100" height="100">
                            <div>
                                <a href="{{ route('products.details', $product->slug) }}">{{ $product->title }}</a> |
                                <span>{{ $product->price }} €</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </section>
    </main>
@endsection
