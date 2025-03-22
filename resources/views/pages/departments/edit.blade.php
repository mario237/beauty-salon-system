@extends('layouts.master')
@section('title', __('general.edit_department'))

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">{{ __('general.departments') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> {{ __('general.dashboard') }}
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.departments.index') }}" class="f-s-14 f-w-500">{{ __('general.departments') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.departments.edit', $department->id) }}" class="f-s-14 f-w-500">{{ __('general.edit_department') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>{{ __('general.department_data') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.departments.update', $department->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-4">
                                <label for="name">{{ __('general.name') }}</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="{{ __('general.ex_category_name') }}" required
                                       type="text" name="name" value="{{ old('name', $department->name) }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn ripple btn-primary" type="submit">{{ __('general.edit') }}</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.departments.index') }}">
                                {{ __('general.back') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
