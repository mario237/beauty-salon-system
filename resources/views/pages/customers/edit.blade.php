@extends('layouts.master')
@section('title', __('general.edit_customer'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">{{ __('general.customers') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> {{ __('general.dashboard') }}
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.customers.index') }}" class="f-s-14 f-w-500">{{ __('general.customers') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="f-s-14 f-w-500">{{ __('general.edit_customer') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>{{ __('general.customer_data') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.customers.update', $customer->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-4">
                                <label for="name">{{ __('general.name') }}</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="{{ __('general.ex_john_doe') }}" required
                                       type="text" name="name" value="{{ old('name', $customer->name) }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group my-4">
                                <label for="phone_number">{{ __('general.phone_number') }}</label>
                                <input id="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="{{ __('general.ex_phone') }}" type="text" name="phone_number"
                                       value="{{ old('phone_number', $customer->phone_number) }}"
                                       required
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group my-4">
                                <label for="source">{{ __('general.source') }}</label>

                                <select class="select-example form-select select-basic" name="source">
                                    @foreach($sources as $source)
                                        <option
                                            value="{{ $source }}"
                                            {{ $customer->source === $source ? 'selected' : '' }}
                                        >{{ \Illuminate\Support\Str::headline($source) }}</option>
                                    @endforeach
                                </select>
                                @error('source')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn ripple btn-primary" type="submit">{{ __('general.update') }}</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.customers.index') }}">
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
