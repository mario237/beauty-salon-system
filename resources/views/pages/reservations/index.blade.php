@extends('layouts.master')
@section('title', __('general.reservations'))
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/toastify/toastify.css')}}">

@endpush
@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.reservations') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('general.dashboard') }}</a></li>
                    <li class="active"><a href="{{ route('admin.reservations.index') }}">{{ __('general.reservations') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('admin.reservations.create') }}">{{ __('general.add_reservation') }}</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="app-datatable-default overflow-auto">
                            <table id="example" class="display app-data-table default-data-table">
                                <thead>
                                <tr>
                                    <th>{{ __('general.customer') }} {{ __('general.name') }}</th>
                                    <th>{{ __('general.customer') }} {{ __('general.phone') }}</th>
                                    <th>{{ __('general.start_time') }}</th>
                                    <th>{{ __('general.end_time') }}</th>
                                    <th>{{ __('general.total_price') }}</th>
                                    <th>{{ __('general.status') }}</th>
                                    <th>{{ __('general.payment_status') }}</th>
                                    <th>{{ __('general.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->customer->name }}</td>
                                        <td>{{ $reservation->customer->phone_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->start_datetime)->format('d M Y - h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->end_datetime)->format('d M Y - h:i A') }}</td>
                                        <td>{{ $reservation->total_price }} EGP</td>
                                        <td>
                                            @if($reservation->status === 'pending')
                                                <span
                                                    class="badge text-warning">{{ __('general.pending') }}</span>
                                            @elseif($reservation->status === 'confirmed')
                                                <span
                                                    class="badge text-success">{{ __('general.confirmed') }}</span>
                                            @elseif($reservation->status === 'cancelled')
                                                <span
                                                    class="badge text-danger">{{ __('general.cancelled') }}</span>
                                            @else
                                                <span class="badge text-info">{{ ucfirst($reservation->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                             <span
                                                 class="badge text-{{ $reservation->transactions->where('status', 'paid')->count() ? 'success' : 'danger' }}">
                                             {{ $reservation->transactions->where('status', 'paid')->count() ? __('general.paid') : __('general.unpaid') }}
                                    </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                               type="button"
                                               class="btn btn-light-primary icon-btn b-r-4">
                                                <i class="ti ti-edit text-primary"></i>
                                            </a>
                                            <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                                               type="button"
                                               class="btn btn-light-info icon-btn b-r-4">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-light-danger icon-btn b-r-4"
                                                    onclick="deleteReservation('{{ $reservation->id }}')">
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
            console.log(message)
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
        function deleteReservation(id) {
            let url = '{{ route("admin.reservations.destroy", ":id") }}';
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
