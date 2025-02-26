@extends('layouts.master')
@section('title', 'Edit employee')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Employees</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> Dashboard
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.employees.index') }}" class="f-s-14 f-w-500">Employees</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="f-s-14 f-w-500">Edit employee</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>Employee Data</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.employees.update', $employee->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-4">
                                <label for="name">Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Ex: John Doe" required
                                       type="text" name="name" value="{{ old('name', $employee->name) }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group my-4">
                                <label for="phone_number">Phone Number</label>
                                <input id="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="Ex: 01012345678" type="text" name="phone_number"
                                       value="{{ old('phone_number', $employee->phone_number) }}"
                                       required
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group my-4">
                                <label for="services">Services</label>

                                <select class="select-example form-select select-basic" name="services[]" multiple>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                                @if(isset($employee) && $employee->services->contains($service->id)) selected @endif>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('services')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn ripple btn-primary" type="submit">Edit</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.employees.index') }}">
                                back
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
