@extends('admin.layouts.app')

@section('title', 'Cart Items')

@section('content')
<div class="container mt-4">
    <h2>Cart Items for User ID 1</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-info">No items in cart.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (₹)</th>
                    <th>Subtotal (₹)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php
                        $subtotal = $item->quantity * $item->product->price;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->product->price, 2) }}</td>
                        <td>{{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th>₹{{ number_format($total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    @endif
</div>
@endsection
