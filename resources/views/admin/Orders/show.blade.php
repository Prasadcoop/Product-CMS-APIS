@extends('admin.layouts.app')
@section('title', 'Order Detail')

@section('content')
<div class="container mt-4">
    <h2>Order #{{ $order->id }}</h2>
    <p><strong>User:</strong> {{ $order->user->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
    <hr>
    <h5>Order Items:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price, 2) }}</td>
                <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
