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
                    <li><a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500"><i
                                class="ph-duotone ph-table f-s-16"></i> Dashboard</a></li>
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
                                <p><strong>Date &
                                        Time:</strong> {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('d M Y - h:i A') }}
                                </p>
                                <p class="my-2"><strong>Status:</strong>
                                    @if($reservation->status === 'pending')
                                        <span
                                            class="badge text-warning f-s-12">{{ ucfirst($reservation->status) }}</span>
                                        <button class="btn btn-success btn-sm mx-2"
                                                onclick="acceptReservation('{{ $reservation->id }}')">
                                            <i class="ti ti-check"></i> Confirm
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                onclick="rejectReservation('{{ $reservation->id }}')">
                                            <i class="ti ti-close"></i> Cancel
                                        </button>
                                    @elseif ($reservation->status === 'cancelled')
                                        <span
                                            class="badge text-danger f-s-12">{{ ucfirst($reservation->status) }}</span>
                                        <button class="btn btn-primary btn-sm" onclick="viewCancelledReason()">
                                            <i class="ti ti-info-alt"></i> View Reason
                                        </button>

                                        <!-- Cancellation Reason Modal -->
                                <div class="modal fade" id="cancelReasonModal" tabindex="-1"
                                     aria-labelledby="cancelReasonModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelReasonModalLabel">Cancellation
                                                    Reason</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="cancelReasonText">{{ $reservation->cancel_reason }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($reservation->status === 'confirmed')
                                    <span
                                        class="badge text-success f-s-12">{{ ucfirst($reservation->status) }}</span>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="ti ti-credit-card"></i> Pay Now
                                    </button>

                                    <!-- Payment Modal -->
                                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="paymentForm">
                                                        @csrf
                                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Amount</label>
                                                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $reservation->total }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="payment_method" class="form-label">Payment Method</label>
                                                            <select class="form-control" id="payment_method" name="payment_method" required>
                                                                @foreach(getPaymentMethods() as $paymentMethod)
                                                                    <option value="{{ $paymentMethod['value'] }}">{{ $paymentMethod['text'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-success w-100">Submit Payment</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span
                                        class="badge text-info f-s-12">{{ ucfirst($reservation->status) }}</span>
                                @endif

                                <p class="my-2"><strong>Payment:</strong>
                                    <span class="badge text-{{ $reservation->transactions->where('status', 'paid')->count() ? 'success' : 'danger' }}">
                                             {{ $reservation->transactions->where('status', 'paid')->count() ? 'Paid' : 'Unpaid' }}
                                    </span>
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

                        <h6 class="mb-3"><i class="ti ti-credit-card"></i> Transactions</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                <tr>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reservation->transactions as $transaction)
                                    <tr>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                                        <td>
                        <span class="badge text-{{ $transaction->status === 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d M Y - h:i A') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>


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

        function acceptReservation(id) {
            Swal.fire({
                title: "Confirm Reservation",
                text: "Are you sure you want to confirm this reservation?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.reservations.updateStatus") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: 'confirmed',
                        },
                        success: function (response) {
                            Swal.fire("Confirmed!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        }

        function rejectReservation(id) {
            Swal.fire({
                title: "Cancel Reservation",
                input: "textarea",
                inputLabel: "Enter cancellation reason",
                inputPlaceholder: "Type your reason here...",
                inputAttributes: {
                    required: "true"
                },
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage("Reason is required");
                    } else {
                        return reason;
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.reservations.updateStatus") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: 'cancelled',
                            reason: result.value
                        },
                        success: function (response) {
                            Swal.fire("Cancelled!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        }

        function viewCancelledReason() {
            $('#cancelReasonModal').modal('show'); // Show the modal
        }

        function openPaymentModal(reservationId) {
            $('#reservation_id').val(reservationId);
            $('#paymentModal').modal('show');
        }

        $(document).ready(function() {
            $('#paymentForm').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("admin.transactions.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire("Success!", response.message, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", xhr.responseJSON.message, "error");
                    }
                });
            });
        });
    </script>
@endpush
