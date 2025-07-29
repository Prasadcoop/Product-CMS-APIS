@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <h2>Edit Product</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price">Price (₹)</label>
            <input type="number" name="price" step="0.01" class="form-control" required value="{{ old('price', $product->price) }}">
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
