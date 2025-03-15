@extends('layouts.master')
@section('title', 'Add new category')

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Categories</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> Dashboard
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.categories.index') }}" class="f-s-14 f-w-500">Categories</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.categories.create') }}" class="f-s-14 f-w-500">Add new category</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>Category Data</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.categories.store')}}" method="post">
                            @csrf
                            <div class="form-group my-4">
                                <label for="name">Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Ex: Skincare" required
                                       type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group my-4">
                                <label for="is_active">Active</label>
                                <input id="is_active" type="checkbox" name="is_active" value="1"
                                       class="form-check-input" checked>
                            </div>


                            <button class="btn ripple btn-primary" type="submit">Save</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.categories.index') }}">
                                back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
