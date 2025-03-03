@extends('layouts.master')

@section('title', 'Reservation Details')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select/select2.min.css') }}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">Reservation Details</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500"><i class="ph-duotone ph-table f-s-16"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.reservations.index') }}" class="f-s-14 f-w-500">Reservations</a></li>
                    <li class="active"><a href="#" class="f-s-14 f-w-500">View Reservation</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Reservation #{{ $reservation->id }}</h5>
                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="ti ti-user"></i> Customer Information</h6>
                                <p><strong>Name:</strong> {{ $reservation->customer->name }}</p>
                                <p class="my-2"><strong>Phone:</strong> {{ $reservation->customer->phone_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="ti ti-calendar"></i> Reservation Details</h6>
                                <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('d M Y - h:i A') }}</p>
                                <p class="my-2"><strong>Status:</strong>
                                    @if($reservation->status === 'pending')
                                        <span class="badge text-warning f-s-12">{{ $reservation->status }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3"><i class="ti ti-briefcase"></i> Services</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                <tr>
                                    <th>Service</th>
                                    <th>Employee</th>
                                    <th>Discount</th>
                                    <th>Discount Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reservation->services as $service)
                                    <tr>
                                        <td>{{ $service->service->name }}</td>
                                        <td>{{ $service->employee ? $service->employee->name : 'Not Assigned' }}</td>
                                        <td>{{ $service->discount }}</td>
                                        <td>{{ ucfirst($service->discount_type) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($reservation->note)
                            <hr>
                            <h6 class="mb-3"><i class="ti ti-note"></i> Notes</h6>
                            <p>{{ $reservation->note }}</p>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-secondary" href="{{ route('admin.reservations.index') }}">
                                <i class="ti ti-arrow-left"></i> Back
                            </a>
                            <button class="btn btn-danger" onclick="deleteReservation('{{ $reservation->id }}')">
                                <i class="ti ti-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="delete-form" action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>
    <script>
        function deleteReservation(id) {
            let url = '{{ route("admin.reservations.destroy", ":id") }}';
            url = url.replace(':id', id);
            let message = '';
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
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
                            `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Successfully",
                        text: message,
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('admin.reservations.index') }}"
                        }
                    })
                }
            });
        }
    </script>
@endpush
