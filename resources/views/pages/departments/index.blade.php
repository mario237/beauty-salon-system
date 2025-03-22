@extends('layouts.master')
@section('title', __('general.departments'))
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/toastify/toastify.css')}}">

@endpush

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
                    <li class="active">
                        <a href="{{ route('admin.departments.index') }}" class="f-s-14 f-w-500">{{ __('general.departments') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <a class="btn btn-primary btn-md" href="{{ route('admin.departments.create') }}">{{ __('general.add_department') }}</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="app-datatable-default overflow-auto">
                            <table id="example" class="display app-data-table default-data-table">
                                <thead>
                                <tr>
                                    <th>{{ __('general.name') }}</th>
                                    <th>{{ __('general.added_by') }}</th>
                                    <th>{{ __('general.added_at') }}</th>
                                    <th>{{ __('general.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>{{ $department->name }}</td>

                                        <td>{{ $department->addedBy->name }}</td>
                                        <td>{{ $department->created_at->format('Y-m-d h:s A') }}</td>
                                        <td>
                                            <a href="{{ route('admin.departments.edit', $department->id) }}"
                                               type="button"
                                               class="btn btn-light-primary icon-btn b-r-4">
                                                <i class="ti ti-edit text-primary"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-light-danger icon-btn b-r-4"
                                                    onclick="deleteDepartment('{{ $department->id }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/data_table.js') }}"></script>
    <!-- toatify js-->
    <script src="{{asset('assets/vendor/notifications/toastify-js.js')}}"></script>
    <script src="{{asset('assets/vendor/toastify/toastify.js')}}"></script>
    <!-- Toatify js-->
    <script src="{{asset('assets/vendor/notifications/toastify-js.js')}}"></script>

    <!-- sweetalert js-->
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>
    <!-- notification js -->
    @if(session()->has('success'))
        <script>
            let message = "{{ session()->get('success') }}";
            Toastify({
                text: message,
                duration: 3000,
                position: "right",
                style: {
                    background: "rgb(var(--success),1)",
                }
            }).showToast();
        </script>
        @php session()->forget('success') @endphp
    @endif

    <script>
        function deleteDepartment(id) {
            let url = '{{ route("admin.departments.destroy", ":id") }}';
            url = url.replace(':id', id);
            let message = '';
            Swal.fire({
                title: "{{ __('general.are_you_sure') }}",
                text: "{{ __('general.wont_revert') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('general.yes_delete') }}",
                cancelButtonText: "{{ __('general.cancel') }}",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                            'Content-Type': 'application/json',
                        },
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    }).then(data => {
                        message = data.message;
                    }).catch(error => {
                        Swal.showValidationMessage(
                            `{{ __('general.request_failed') }}: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "{{ __('general.successfully') }}",
                        text: message,
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }
            });
        }
    </script>
@endpush
