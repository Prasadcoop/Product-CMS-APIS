@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container mt-4">
    <h2>Add Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price">Price (₹)</label>
            <input type="number" name="price" step="0.01" class="form-control" required value="{{ old('price') }}">
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
       <div class="mb-3">
            <label for="images">Product Images</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            @error('images') <div class="text-danger">{{ $message }}</div> @enderror
            @error('images.*') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection