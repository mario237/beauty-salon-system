@extends('layouts.master')
@section('title', 'Edit department')


@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Customers</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-table f-s-16"></i> Dashboard
                      </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.departments.index') }}" class="f-s-14 f-w-500">Departments</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.departments.edit', $department->id) }}" class="f-s-14 f-w-500">Edit department</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>Customer Data</h5>
                    </div>
                    <div class="card-body p-0">
                        <form class="m-3 app-form" action="{{route('admin.departments.update', $department->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-4">
                                <label for="name">Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Ex: John Doe" required
                                       type="text" name="name" value="{{ old('name', $department->name) }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <button class="btn ripple btn-primary" type="submit">Edit</button>
                            <a class="btn ripple btn-secondary" href="{{ route('admin.departments.index') }}">
                                back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
