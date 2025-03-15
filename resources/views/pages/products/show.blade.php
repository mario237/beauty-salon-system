@extends('layouts.master')
@section('title', 'View Product')

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">Product Details</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                            <i class="ph-duotone ph-table f-s-16"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="f-s-14 f-w-500">Products</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">View Product</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Product Information -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="mb-4 text-primary"><i class="ti ti-info-circle"></i> Product Information</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> {{ $product->name }}</li>
                            <li class="list-group-item">
                                <strong>Description:</strong>
                                <p class="mt-1 text-muted">{!! $product->description ?? '<i>No description available</i>' !!}</p>
                            </li>
                            <li class="list-group-item"><strong>Price:</strong> <span class="text-success">{{ number_format($product->price, 2) }}EGP</span></li>
                            <li class="list-group-item"><strong>Stock:</strong> <span class="badge bg-warning text-dark">{{ $product->stock }}</span></li>
                            <li class="list-group-item"><strong>Categories:</strong> <span class="text-info">{{ $product->categories->pluck('name')->join(', ') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="mb-4 text-primary"><i class="ti ti-image"></i> Product Images</h5>
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                <div class="col-4">
                                    <div class="image-preview position-relative">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded shadow-sm border" style="max-width: 100%; height: auto;">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="ti ti-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                    <i class="ti ti-pencil"></i> Edit Product
                </a>
            </div>
        </div>
    </div>
@endsection
