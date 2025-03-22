@extends('layouts.master')
@section('title', __('general.view_product'))

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.product_details') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                            <i class="ph-duotone ph-table f-s-16"></i> {{ __('general.dashboard') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="f-s-14 f-w-500">{{ __('general.products') }}</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">{{ __('general.view_product') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Product Information -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="mb-4 text-primary"><i class="ti ti-info-circle"></i> {{ __('general.product_information') }}</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>{{ __('general.name') }}:</strong> {{ $product->name }}</li>
                            <li class="list-group-item">
                                <strong>{{ __('general.description') }}:</strong>
                                <p class="mt-1 text-muted">{!! $product->description ?? '<i>' . __('general.no_description_available') . '</i>' !!}</p>
                            </li>
                            <li class="list-group-item"><strong>{{ __('general.price') }}:</strong> <span class="text-success">{{ number_format($product->price, 2) }}EGP</span></li>
                            <li class="list-group-item"><strong>{{ __('general.stock') }}:</strong> <span class="badge bg-warning text-dark">{{ $product->stock }}</span></li>
                            <li class="list-group-item"><strong>{{ __('general.categories') }}:</strong> <span class="text-info">{{ $product->categories->pluck('name')->join(', ') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="mb-4 text-primary"><i class="ti ti-image"></i> {{ __('general.product_images') }}</h5>
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
                    <i class="ti ti-arrow-left"></i> {{ __('general.back_to_products') }}
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                    <i class="ti ti-pencil"></i> {{ __('general.edit_product') }}
                </a>
            </div>
        </div>
    </div>
@endsection
