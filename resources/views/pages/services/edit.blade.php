@extends('layouts.master')
@section('title', __('general.edit_service'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">{{ __('general.services') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> {{ __('general.dashboard') }}
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.services.index') }}" class="f-s-14 f-w-500">{{ __('general.services') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.services.edit', $service->id) }}" class="f-s-14 f-w-500">{{ __('general.edit_service') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>{{ __('general.service_data') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.services.update', $service->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-4">
                                <label for="name">{{ __('general.name') }}</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="{{ __('general.ex_category_name') }}" required
                                       type="text" name="name" value="{{ old('name', $service->name) }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group my-4">
                                <label for="price">{{ __('general.price') }} (EGP)</label>
                                <input id="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       placeholder="Ex: 100" type="text" name="price"
                                       value="{{ old('price', $service->price) }}"
                                       required>
                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group my-4">
                                <label for="duration">{{ __('general.duration') }} ({{ __('general.minute') }})</label>
                                <input id="duration"
                                       class="form-control @error('duration') is-invalid @enderror"
                                       placeholder="Ex: 100" type="text" name="duration"
                                       value="{{ old('duration', $service->duration) }}"
                                       required>
                                @error('duration')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group my-4">
                                <label for="department_id">{{ __('general.department') }}</label>

                                <select class="select-example form-select select-basic" name="department_id">
                                    @foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}"
                                            {{$department->id === $service->department->id ? 'selected' : '' }}
                                        >{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn ripple btn-primary" type="submit">{{ __('general.edit') }}</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.services.index') }}">
                                {{ __('general.back') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/vendor/select/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/select.js')}}"></script>
@endpush
