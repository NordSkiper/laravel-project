@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="text-center">{{ __('Category') . __(' "' . $category->name . '"')  }}</h3>
                <hr>
                <p>{{ $category->description }}</p>
            </div>
            <div class="col-md-12">
                <div class="album py-5 bg-light">
                    <div class="container">
                        <div class="row">
                            @each('products.parts.product_view', $products, 'product')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
