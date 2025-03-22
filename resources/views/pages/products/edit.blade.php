@extends('layouts.master')
@section('title', __('general.edit_product'))
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/toastify/toastify.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.4/filepond.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond-plugin-image-preview/4.6.11/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.edit_product') }}</h4>
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
                        <a href="#" class="f-s-14 f-w-500">{{ __('general.edit_product') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('general.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('general.description') }}</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('general.price') }}</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">{{ __('general.stock') }}</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="categories" class="form-label">{{ __('general.categories') }}</label>
                                <select class="form-control category-select" id="categories" name="categories[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('categories')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">{{ __('general.product_images') }}</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                <div class="mt-2">
                                    @foreach($product->images as $image)
                                        <div class="image-preview d-inline-block m-2">
                                            <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" width="100" height="100" class="img-thumbnail">
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm remove-image" data-id="{{ $image->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                @error('images')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('general.update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/notifications/toastify-js.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.category-select').select2();

            $('#description').trumbowyg();

            $(document).on('click', '.remove-image', function() {
                let imageId = $(this).data('id');
                let button = $(this);

                Swal.fire({
                    title: "{{ __('general.are_you_sure') }}",
                    text: "{{ __('general.wont_revert') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "{{ __('general.yes_delete') }}",
                    cancelButtonText: "{{ __('general.cancel') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/products/images/${imageId}/delete`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(response) {
                                button.closest('.image-preview').remove();
                                Swal.fire("{{ __('general.deleted') }}", "{{ __('general.image_deleted_success') }}", 'success');
                            },
                            error: function() {
                                Swal.fire("{{ __('general.error') }}", "{{ __('general.something_went_wrong') }}", 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
