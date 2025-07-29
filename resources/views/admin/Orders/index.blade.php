@extends('admin.layouts.app')
@section('title', 'Order List')

@section('content')
<div class="container mt-4">
    <h2>Orders</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
