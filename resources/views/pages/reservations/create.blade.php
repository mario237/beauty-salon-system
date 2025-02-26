@extends('layouts.master')
@section('title', 'Add new reservation')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Reservations</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                            <span><i class="ph-duotone  ph-table f-s-16"></i> Dashboard</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.reservations.index') }}" class="f-s-14 f-w-500">Reservations</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.reservations.create') }}" class="f-s-14 f-w-500">Add new reservation</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h5>Reservation Data</h5>
                    </div>
                    <div class="card-body p-3">
                        <form id="reservation-form" action="{{route('admin.reservations.store')}}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="customer_id">Customer</label>
                                <select id="customer_id" class="form-control select2" name="customer_id">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group my-4">
                                <label for="start_datetime">Start Date & Time</label>
                                <input id="start_datetime" class="form-control" type="datetime-local" name="start_datetime" required>
                            </div>

                            <div id="services-container">
                                <div class="service-group d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="row my-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Service</label>
                                                <select class="form-control select2 service-select" name="services[]">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Employee</label>
                                                <select class="form-control select2 employee-select" name="employees[]">
                                                    <option value="">Select Date time and Service First</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Discount</label>
                                                <input type="number" class="form-control" name="discount[]" step="0.01" value="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Discount Type</label>
                                                <select class="form-control" name="discount_type[]">
                                                    <option value="percentage">Percentage</option>
                                                    <option value="flat">Flat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-service" class="btn btn-secondary mt-2">Add More Services</button>

                            <div class="form-group my-4">
                                <label for="note">Note</label>
                                <textarea id="note" class="form-control" name="note" rows="3"></textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-secondary" href="{{ route('admin.reservations.index') }}">Back</a>
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

                            if (response.length === 0) {
                                employeeSelect.append('<option value="">No employees available</option>');
                            } else {
                                employeeSelect.append('<option value="">Select Employee</option>');
                                response.forEach(employee => {
                                    employeeSelect.append(`<option value="${employee.id}">${employee.name}</option>`);
                                });
                            }
                        }
                    });
                } else {
                    employeeSelect.html('<option value="">Select Service First</option>');
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
                    alert('Please select a start date and time first.');
                    return;
                }

                let newServiceGroup = `
            <div class="service-group d-flex align-items-center">
                <div class="w-100">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <label class="form-label">Service</label>
                            <select class="form-control select2 service-select" name="services[]">
                                @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Employee</label>
                <select class="form-control select2 employee-select" name="employees[]">
                    <option value="">Select Service First</option>
                </select>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-6">
                <label class="form-label">Discount</label>
                <input type="number" class="form-control" name="discount[]" step="0.01" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Discount Type</label>
                    <select class="form-control" name="discount_type[]">
                    <option value="percentage">Percentage</option>
                    <option value="flat">Flat</option>
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
                    alert("At least one service is required.");
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
                        $('#submit-btn').prop('disabled', true).text('Submitting...');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Reservation added successfully!',
                        }).then(() => {
                            window.location.href = "{{ route('admin.reservations.index') }}"; // Redirect on success
                        });
                    },
                    error: function(xhr) {
                        $('#submit-btn').prop('disabled', false).text('Save');
                        let errors = xhr.responseJSON?.errors || { error: ['Something went wrong!'] };

                        let errorMessages = Object.values(errors).flat().join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessages,
                        });
                    }
                });
            });
        });

    </script>
@endpush
