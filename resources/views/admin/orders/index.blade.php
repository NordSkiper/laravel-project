@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
{{--            @if ($message = Session::get('success'))--}}
{{--                <div class="alert alert-success">--}}
{{--                    <p>{{ $message }}</p>--}}
{{--                </div>--}}
{{--            @endif--}}
            <div class="col-md-12">
                <h3 class="text-center">{{ __('Orders') }}</h3>
            </div>
            <div class="col-md-12">
                <table class="table align-self-center">
                    <thread>
                        <tr>
                            <th class="text-center" scope="col">ID</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Name and Surname</th>
                            <th class="text-center" scope="col">Phone</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Products</th>
                            <th class="text-center" scope="col">Total</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thread>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="text-center" scope="col">{{ $order->id }}</td>
                                <td class="text-center" scope="col">{{ $order->status->name }}</td>
                                <td class="text-center" scope="col">{{ $order->name  . ' ' . $order->surname  }}</td>
                                <td class="text-center" scope="col">{{ $order->phone }}</td>
                                <td class="text-center" scope="col">{{ $order->email }}</td>
                                <td class="text-center" scope="col">
                                    <div class="card" style="width: 18rem;">
                                        <ul class="list-group list-group-flush">
                                            @foreach($order->products()->where('order_id', $order->id)->get() as $product)
                                                <li class="list-group-item">{{ $product->title }}
                                                    x{{ $product->pivot->quantity }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-center" scope="col">{{ $order->total }}</td>
                                <td class="text-center" scope="col">
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-info form-control">Edit</a>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-success form-control">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-8">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection