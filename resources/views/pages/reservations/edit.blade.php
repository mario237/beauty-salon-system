@extends('layouts.master')
@section('title', __('general.edit_reservation'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.edit_reservation') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500"><i class="ph-duotone ph-table f-s-16"></i> {{ __('general.dashboard') }}</a></li>
                    <li><a href="{{ route('admin.reservations.index') }}" class="f-s-14 f-w-500">{{ __('general.reservations') }}</a></li>
                    <li class="active"><a href="#" class="f-s-14 f-w-500">{{ __('general.edit_reservation') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('general.reservation_details') }}</h5>
                    </div>
                    <div class="card-body p-3">
                        <form id="reservation-form" action="{{ route('admin.reservations.update', $reservation->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="customer_id">{{ __('general.customer') }}</label>
                                <select id="customer_id" class="form-control select2" name="customer_id">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $customer->id == $reservation->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group my-4">
                                <label for="start_datetime">{{ __('general.start_datetime') }}</label>
                                <input id="start_datetime" class="form-control" type="datetime-local" name="start_datetime" value="{{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d\TH:i') }}" required>
                            </div>

                            <div id="services-container">
                                @foreach ($reservation->services as $index => $service)
                                    <div class="service-group d-flex align-items-center">
                                        <div class="w-100">
                                            <div class="row my-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('general.service') }}</label>
                                                    <select class="form-control select2 service-select" name="services[]">
                                                        @foreach ($services as $s)
                                                            <option value="{{ $s->id }}" {{ $s->id == $service->service_id ? 'selected' : '' }}>{{ $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('general.employee') }}</label>
                                                    <select class="form-control select2 employee-select" name="employees[]">
                                                        <option value="">{{ __('general.select_date_time_service_first') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('general.discount') }}</label>
                                                    <input type="number" class="form-control" name="discount[]" step="0.01" value="{{ $service->discount }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('general.discount_type') }}</label>
                                                    <select class="form-control" name="discount_type[]">
                                                        <option value="percentage" {{ $service->discount_type == 'percentage' ? 'selected' : '' }}>{{ __('general.percentage') }}</option>
                                                        <option value="flat" {{ $service->discount_type == 'flat' ? 'selected' : '' }}>{{ __('general.flat') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <a type="button" class="btn-sm btn-danger remove-service mx-2"><i class="ti ti-trash text-white"></i></a>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-service" class="btn btn-secondary mt-2">{{ __('general.add_more_services') }}</button>

                            <div class="form-group my-4">
                                <label for="note">{{ __('general.note') }}</label>
                                <textarea id="note" class="form-control" name="note" rows="3">{{ $reservation->note }}</textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ __('general.update') }}</button>
                            <a class="btn btn-secondary" href="{{ route('admin.reservations.index') }}">{{ __('general.back') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/vendor/select/select2.min.js')}}"></script>
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function updateEmployeeList(serviceSelect) {
                let serviceId = serviceSelect.val();
                let employeeSelect = serviceSelect.closest('.service-group').find('.employee-select');
                let startTime = $('#start_datetime').val();
                let reservationId = "{{ $reservation->id }}";
                let selectedEmployeeId = null;

                $.ajax({
                    url: `/admin/reservation-employee/${reservationId}/${serviceId}`,
                    type: 'GET',
                    success: function(response) {
                        selectedEmployeeId = response.employee_id
                    }
                });

                if (serviceId && startTime) {
                    $.ajax({
                        url: `/admin/employees-by-service/${serviceId}?start_time=${startTime}&reservation_id=${reservationId}`,
                        type: 'GET',
                        success: function(response) {
                            employeeSelect.empty(); // Clear previous options
                            let employees = Object.values(response.list); // Convert object to array

                            if (response.count === 0) {
                                employeeSelect.append('<option value="">' + "{{ __('general.no_employees_available') }}" + '</option>');
                            } else {
                                employeeSelect.append('<option value="">' + "{{ __('general.select_employee') }}" + '</option>');
                                employees.forEach(employee => {
                                    let isSelected = selectedEmployeeId === employee.id ? 'selected' : '';
                                    employeeSelect.append(`<option value="${employee.id}" ${isSelected}>${employee.name}</option>`);
                                });
                            }
                        }
                    });
                } else {
                    employeeSelect.html('<option value="">' + "{{ __('general.select_service_first') }}" + '</option>');
                }
            }


            $(document).on('change', '.service-select', function() {
                updateEmployeeList($(this));
            });

            $('.service-select').each(function() {
                updateEmployeeList($(this));
            });

            $('#start_datetime').on('change', function() {
                $('.service-select').each(function() {
                    updateEmployeeList($(this));
                });
            });
            $('#add-service').on('click', function() {
                let newServiceGroup = $('#services-container .service-group:first').clone();
                newServiceGroup.find('select').val('');
                newServiceGroup.find('input').val(0);
                $('#services-container').append(newServiceGroup);
                $('.select2').select2();
            });

            $(document).on('click', '.remove-service', function() {
                if ($('.service-group').length > 1) {
                    $(this).closest('.service-group').remove();
                } else {
                    alert("{{ __('general.at_least_one_service_required') }}");
                }
            });

            $('#reservation-form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.reservations.update', $reservation->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire("{{ __('general.success') }}", "{{ __('general.reservation_updated_success') }}", 'success').then(() => {
                            window.location.href = "{{ route('admin.reservations.index') }}";
                        });
                    },
                    error: function(xhr) {
                        let errorMessages = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).flat().join('<br>') : "{{ __('general.something_went_wrong') }}";
                        Swal.fire("{{ __('general.error') }}", errorMessages, 'error');
                    }
                });
            });
        });
    </script>
@endpush
