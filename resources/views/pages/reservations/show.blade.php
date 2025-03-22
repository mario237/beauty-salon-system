@extends('layouts.master')

@section('title', __('general.reservation_details'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select/select2.min.css') }}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.reservation_details') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500"><i
                                class="ph-duotone ph-table f-s-16"></i> {{ __('general.dashboard') }}</a></li>
                    <li><a href="{{ route('admin.reservations.index') }}" class="f-s-14 f-w-500">{{ __('general.reservations') }}</a></li>
                    <li class="active"><a href="#" class="f-s-14 f-w-500">{{ __('general.view_reservation') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ __('general.reservation') }} #{{ $reservation->id }}</h5>
                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i> {{ __('general.edit') }}
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="ti ti-user"></i> {{ __('general.customer_information') }}</h6>
                                <p><strong>{{ __('general.name') }}:</strong> {{ $reservation->customer->name }}</p>
                                <p class="my-2"><strong>{{ __('general.phone') }}:</strong> {{ $reservation->customer->phone_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class="ti ti-calendar"></i> {{ __('general.reservation_details') }}</h6>
                                <p><strong>{{ __('general.date') }} &
                                        {{ __('general.time') }}:</strong> {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('d M Y - h:i A') }}
                                </p>
                                <p class="my-2"><strong>{{ __('general.total_reservation') }}:</strong>
                                    {{ $reservation->total_price }}
                                </p>
                                <p class="my-2"><strong>{{ __('general.status') }}:</strong>
                                    @if($reservation->status === 'pending')
                                        <span
                                            class="badge text-warning f-s-12">{{ __('general.pending') }}</span>
                                        <button class="btn btn-success btn-sm mx-2"
                                                onclick="acceptReservation('{{ $reservation->id }}')">
                                            <i class="ti ti-check"></i> {{ __('general.confirm') }}
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                onclick="rejectReservation('{{ $reservation->id }}')">
                                            <i class="ti ti-close"></i> {{ __('general.cancel') }}
                                        </button>
                                    @elseif ($reservation->status === 'cancelled')
                                        <span
                                            class="badge text-danger f-s-12">{{ __('general.cancelled') }}</span>
                                        <button class="btn btn-primary btn-sm" onclick="viewCancelledReason()">
                                            <i class="ti ti-info-alt"></i> {{ __('general.view_reason') }}
                                        </button>

                                        <!-- Cancellation Reason Modal -->
                                <div class="modal fade" id="cancelReasonModal" tabindex="-1"
                                     aria-labelledby="cancelReasonModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelReasonModalLabel">{{ __('general.cancellation_reason') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="cancelReasonText">{{ $reservation->cancel_reason }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    {{ __('general.close') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($reservation->status === 'confirmed')
                                    <span
                                        class="badge text-success f-s-12">{{ __('general.confirmed') }}</span>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <i class="ti ti-credit-card"></i> {{ __('general.pay_now') }}
                                    </button>

                                    <!-- Payment Modal -->
                                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentModalLabel">{{ __('general.choose_payment_method') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="paymentForm">
                                                        @csrf
                                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">{{ __('general.amount') }}</label>
                                                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $reservation->total }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="payment_method" class="form-label">{{ __('general.payment_method') }}</label>
                                                            <select class="form-control" id="payment_method" name="payment_method" required>
                                                                @foreach(getPaymentMethods() as $paymentMethod)
                                                                    <option value="{{ $paymentMethod['value'] }}">{{ $paymentMethod['text'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-success w-100">{{ __('general.submit') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span
                                        class="badge text-info f-s-12">{{ ucfirst($reservation->status) }}</span>
                                @endif

                                <p class="my-2"><strong>{{ __('general.payment_status') }}:</strong>
                                    <span class="badge text-{{ $isPaid ? 'success' : 'danger' }}">
                                             {{ $isPaid ? __('general.paid') : __('general.unpaid') }}
                                    </span>
                                </p>

                                <p class="my-2"><strong>{{ __('general.total_paid') }}:</strong>
                                    {{ $totalPaid }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3"><i class="ti ti-briefcase"></i> {{ __('general.services') }}</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                <tr>
                                    <th>{{ __('general.service') }}</th>
                                    <th>{{ __('general.employee') }}</th>
                                    <th>{{ __('general.discount') }}</th>
                                    <th>{{ __('general.discount_type') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reservation->services as $service)
                                    <tr>
                                        <td>{{ $service->service->name }}</td>
                                        <td>{{ $service->employee ? $service->employee->name : __('general.not_assigned') }}</td>
                                        <td>{{ $service->discount }}</td>
                                        <td>{{ ucfirst($service->discount_type) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($reservation->note)
                            <hr>
                            <h6 class="mb-3"><i class="ti ti-note"></i> {{ __('general.notes') }}</h6>
                            <p>{{ $reservation->note }}</p>
                        @endif

                        <h6 class="mb-3"><i class="ti ti-credit-card"></i> {{ __('general.transactions') }}</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                <tr>
                                    <th>{{ __('general.amount') }}</th>
                                    <th>{{ __('general.payment_method') }}</th>
                                    <th>{{ __('general.status') }}</th>
                                    <th>{{ __('general.created_at') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reservation->transactions as $transaction)
                                    <tr>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                                        <td>
                        <span class="badge text-{{ $transaction->status === 'paid' ? 'success' : 'danger' }}">
                            {{ $transaction->status === 'paid' ? __('general.paid') : __('general.unpaid') }}
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
                                <i class="ti ti-arrow-left"></i> {{ __('general.back') }}
                            </a>
                            <button class="btn btn-danger" onclick="deleteReservation('{{ $reservation->id }}')">
                                <i class="ti ti-trash"></i> {{ __('general.delete') }}
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                            window.location.href = "{{ route('admin.reservations.index') }}"
                        }
                    })
                }
            });
        }

        function acceptReservation(id) {
            Swal.fire({
                title: "{{ __('general.confirm_reservation') }}",
                text: "{{ __('general.are_you_sure_confirm_reservation') }}",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "{{ __('general.confirm') }}",
                cancelButtonText: "{{ __('general.cancel') }}",
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
                            Swal.fire("{{ __('general.confirmed') }}!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire("{{ __('general.error') }}!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        }

        function rejectReservation(id) {
            Swal.fire({
                title: "{{ __('general.cancel_reservation') }}",
                input: "textarea",
                inputLabel: "{{ __('general.enter_cancellation_reason') }}",
                inputPlaceholder: "{{ __('general.type_reason_here') }}",
                inputAttributes: {
                    required: "true"
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('general.confirm') }}",
                cancelButtonText: "{{ __('general.cancel') }}",
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage("{{ __('general.reason_required') }}");
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
                            Swal.fire("{{ __('general.cancelled') }}!", response.message, "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire("{{ __('general.error') }}!", xhr.responseJSON.message, "error");
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
                        Swal.fire("{{ __('general.success') }}!", response.message, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("{{ __('general.error') }}!", xhr.responseJSON.message, "error");
                    }
                });
            });
        });
    </script>
@endpush
