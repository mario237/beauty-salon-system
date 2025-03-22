@extends('layouts.master')
@section('title', __('general.add_new_reservation'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">{{ __('general.reservations') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                            <span><i class="ph-duotone  ph-table f-s-16"></i> {{ __('general.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.reservations.index') }}" class="f-s-14 f-w-500">{{ __('general.reservations') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.reservations.create') }}" class="f-s-14 f-w-500">{{ __('general.add_new_reservation') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>{{ __('general.reservation_data') }}</h5>
                    </div>
                    <div class="card-body p-3">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                            {{ __('general.add_new_customer') }}
                        </button>
                        <!-- Create Customer Modal -->
                        <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createCustomerModalLabel">{{ __('general.create_customer') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-customer-form">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="customer-name" class="form-label">{{ __('general.name') }}</label>
                                                <input type="text" class="form-control" id="customer-name" name="name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="customer-phone" class="form-label">{{ __('general.phone_number') }}</label>
                                                <input type="text" class="form-control" id="customer-phone" name="phone_number" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="customer-source" class="form-label">{{ __('general.source') }}</label>
                                                <select class="form-control" id="customer-source" name="source">
                                                    @foreach($sources as $source)
                                                        <option value="{{ $source }}">{{ Str::headline($source) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">{{ __('general.save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="reservation-form" action="{{route('admin.reservations.store')}}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="customer_id">{{ __('general.customer') }}</label>
                                <select id="customer_id" class="form-control select2" name="customer_id">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group my-4">
                                <label for="start_datetime">{{ __('general.start_datetime') }}</label>
                                <input id="start_datetime" class="form-control" type="datetime-local" name="start_datetime" required>
                            </div>

                            <div id="services-container">
                                <div class="service-group d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="row my-3">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('general.service') }}</label>
                                                <select class="form-control select2 service-select" name="services[]">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
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
                                                <input type="number" class="form-control" name="discount[]" step="0.01" value="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('general.discount_type') }}</label>
                                                <select class="form-control" name="discount_type[]">
                                                    <option value="percentage">{{ __('general.percentage') }}</option>
                                                    <option value="flat">{{ __('general.flat') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-service" class="btn btn-secondary mt-2">{{ __('general.add_more_services') }}</button>

                            <div class="form-group my-4">
                                <label for="note">{{ __('general.note') }}</label>
                                <textarea id="note" class="form-control" name="note" rows="3"></textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ __('general.save') }}</button>
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

            // Function to load employees based on selected service and start time
            function updateEmployeeList(serviceSelect) {
                let serviceId = serviceSelect.val();
                let employeeSelect = serviceSelect.closest('.service-group').find('.employee-select');
                let startTime = $('#start_datetime').val();

                if (serviceId && startTime) {
                    $.ajax({
                        url: `/admin/employees-by-service/${serviceId}?start_time=${startTime}`,
                        type: 'GET',
                        success: function(response) {
                            employeeSelect.empty(); // Clear previous options
                            let employees = Object.values(response.list); // Convert object to array

                            console.log(response)
                            if (response.count === 0) {
                                employeeSelect.append('<option value="">' + "{{ __('general.no_employees_available') }}" + '</option>');
                            } else {
                                employeeSelect.append('<option value="">' + "{{ __('general.select_employee') }}" + '</option>');
                                employees.forEach(employee => {
                                    employeeSelect.append(`<option value="${employee.id}">${employee.name}</option>`);
                                });
                            }
                        }
                    });
                } else {
                    employeeSelect.html('<option value="">' + "{{ __('general.select_service_first') }}" + '</option>');
                }
            }

            // Event listener for service selection change
            $(document).on('change', '.service-select', function() {
                updateEmployeeList($(this));
            });

            // Update employee list when start datetime changes
            $('#start_datetime').on('change', function() {
                $('.service-select').each(function() {
                    updateEmployeeList($(this));
                });
            });

            // Add new service entry
            $('#add-service').on('click', function() {
                let startTime = $('#start_datetime').val();

                if (!startTime) {
                    alert("{{ __('general.select_start_date_time_first') }}");
                    return;
                }

                let newServiceGroup = `
            <div class="service-group d-flex align-items-center">
                <div class="w-100">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('general.service') }}</label>
                            <select class="form-control select2 service-select" name="services[]">
                                @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('general.employee') }}</label>
                <select class="form-control select2 employee-select" name="employees[]">
                    <option value="">{{ __('general.select_service_first') }}</option>
                </select>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-6">
                <label class="form-label">{{ __('general.discount') }}</label>
                <input type="number" class="form-control" name="discount[]" step="0.01" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('general.discount_type') }}</label>
                    <select class="form-control" name="discount_type[]">
                    <option value="percentage">{{ __('general.percentage') }}</option>
                    <option value="flat">{{ __('general.flat') }}</option>
                </select>
            </div>
        </div>
    </div>
    <a type="button" class="btn-sm btn-danger remove-service mx-2"><i class="ti ti-trash text-white"></i></a>
</div>
`;

                $('#services-container').append(newServiceGroup);
                $('.select2').select2(); // Reinitialize select2 for new elements

                // Auto-select first service and update employees list
                let newServiceSelect = $('#services-container .service-group:last-child .service-select');
                let firstServiceId = newServiceSelect.find('option:first').val();
                newServiceSelect.val(firstServiceId).trigger('change');
            });

            // Remove service entry
            $(document).on('click', '.remove-service', function() {
                if ($('.service-group').length > 1) {
                    $(this).closest('.service-group').remove();
                } else {
                    alert("{{ __('general.at_least_one_service_required') }}");
                }
            });

            $('#reservation-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.reservations.store') }}", // Adjust route as needed
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#submit-btn').prop('disabled', true).text("{{ __('general.submitting') }}");
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('general.success') }}",
                            text: "{{ __('general.reservation_added_success') }}",
                        }).then(() => {
                            window.location.href = "{{ route('admin.reservations.index') }}"; // Redirect on success
                        });
                    },
                    error: function(xhr) {
                        $('#submit-btn').prop('disabled', false).text("{{ __('general.save') }}");
                        let errors = xhr.responseJSON?.errors || { error: ["{{ __('general.something_went_wrong') }}"] };

                        let errorMessages = Object.values(errors).flat().join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('general.error') }}",
                            html: errorMessages,
                        });
                    }
                });
            });
        });

        $('#create-customer-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.customers.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: "{{ __('general.success') }}",
                        text: "{{ __('general.customer_added_success') }}"
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors || { error: ["{{ __('general.something_went_wrong') }}"] };
                    let errorMessages = Object.values(errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('general.error') }}",
                        html: errorMessages
                    });
                }
            });
        });

    </script>
@endpush
