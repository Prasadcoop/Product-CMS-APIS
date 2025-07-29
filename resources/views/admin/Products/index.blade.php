@extends('admin.layouts.app')

@section('title', 'Product List')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price (₹)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->img_path) }}" alt="Product Image" width="50" class="me-1 mb-1">
                    @else
                    <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this product?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection