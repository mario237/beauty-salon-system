@extends('layouts.master')
@section('title', 'Dashboard')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-4">
                    <div class="card courses-cards card-success">
                        <div class="card-body">
                            <i class="ph-duotone  ph-calendar-check icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-calendar-check text-success f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Reservation::count() }}</h4>
                                <p class="f-w-500 mb-0">Reservations</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card courses-cards card-success">
                        <div class="card-body">
                            <i class="ph-duotone  ph-calendar-check icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-calendar-check text-success f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Transaction::sum('amount') }}</h4>
                                <p class="f-w-500 mb-0">Earnings</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card courses-cards card-success">
                        <div class="card-body">
                            <i class="ph-duotone  ph-calendar-check icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-calendar-check text-success f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Department::count() }}</h4>
                                <p class="f-w-500 mb-0">Departments</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card courses-cards card-info">
                        <div class="card-body">
                            <i class="ph-duotone  ph-projector-screen-chart icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-projector-screen-chart text-info f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Service::count() }}</h4>
                                <p class="f-w-500 mb-0">Services</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card courses-cards card-primary">
                        <div class="card-body">
                            <i class="ph-duotone  ph-graduation-cap icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-graduation-cap text-primary f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Customer::count() }}</h4>
                                <p class="f-w-500 mb-0">Customers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card courses-cards card-warning">
                        <div class="card-body">
                            <i class="ph-duotone  ph-pencil-line icon-bg"></i>
                            <span class="bg-white h-50 w-50 d-flex-center b-r-15">
                          <i class="ph-duotone  ph-pencil-line text-warning text-warning f-s-24"></i>
                        </span>
                            <div class="mt-5">
                                <h4>{{ \App\Models\Employee::count() }}</h4>
                                <p class="f-w-500 mb-0">Employees</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Calendar Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Reservation Calendar</h5>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src='{{ asset('assets/js/full-calendar.min.js') }}'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the calendar element
            let calendarEl = document.getElementById('calendar');

            // Parse the reservations data from the server
            let reservations = @json($reservations);

            // Initialize the calendar
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: reservations,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                eventClick: function(info) {
                    // You can add a modal or redirect to show details
                    alert('Reservation: ' + info.event.title + '\nTime: ' + info.event.start.toLocaleString());
                },
                eventDidMount: function(info) {
                    // Add tooltip with reservation details on hover
                    const tooltip = document.createElement('div');
                    tooltip.classList.add('tooltip');
                    tooltip.innerHTML =
                        '<strong>' + info.event.title + '</strong><br>' +
                        'Start: ' + new Date(info.event.start).toLocaleString() + '<br>' +
                        'End: ' + new Date(info.event.end || info.event.start).toLocaleString();

                    // Create bootstrap tooltip
                    new bootstrap.Tooltip(info.el, {
                        title: tooltip.innerHTML,
                        html: true,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });

            // Render the calendar
            calendar.render();

            // Add event listeners to the filter buttons
            document.getElementById('dayView').addEventListener('click', function() {
                calendar.changeView('timeGridDay');
                setActiveButton(this);
            });

            document.getElementById('weekView').addEventListener('click', function() {
                calendar.changeView('timeGridWeek');
                setActiveButton(this);
            });

            document.getElementById('monthView').addEventListener('click', function() {
                calendar.changeView('dayGridMonth');
                setActiveButton(this);
            });

            // Helper function to set active button state
            function setActiveButton(activeButton) {
                document.querySelectorAll('.filter-buttons button').forEach(function(button) {
                    button.classList.remove('active');
                });
                activeButton.classList.add('active');
            }
        });
    </script>


@endpush
