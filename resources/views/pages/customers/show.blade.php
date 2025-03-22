@extends('layouts.master')
@section('title', __('general.customer_details'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/select/select2.min.css')}}">
    <style>
        .customer-profile {
            position: relative;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin-right: 20px;
        }
        .customer-data-card {
            transition: all 0.3s ease;
        }
        .customer-data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .info-label {
            font-weight: 500;
            color: #6c757d;
        }
        .info-value {
            font-weight: 600;
            color: #2c3e50;
        }
        .action-btn {
            margin-right: 10px;
            border-radius: 5px;
            padding: 8px 15px;
        }
    </style>
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.customer_details') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('admin.dashboard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-table f-s-16"></i> {{ __('general.dashboard') }}
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.customers.index') }}" class="f-s-14 f-w-500">{{ __('general.customers') }}</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">{{ $customer->name }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Customer Profile Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card customer-profile">
                    <div class="card-body">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="mb-1">{{ $customer->name }}</h3>
                                <p class="text-muted mb-0">
                                    <i class="ph-duotone ph-user-circle me-1"></i> {{ __('general.customer') }} #{{ $customer->id }}
                                </p>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary action-btn">
                                    <i class="ph-duotone ph-pencil me-1"></i> {{ __('general.edit') }}
                                </a>
                                <button type="button" class="btn btn-danger action-btn" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal">
                                    <i class="ph-duotone ph-trash me-1"></i> {{ __('general.delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Cards -->
        <div class="row">
            <!-- Basic Information -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 customer-data-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="ph-duotone ph-info me-2"></i>{{ __('general.basic_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="info-label mb-1">{{ __('general.full_name') }}</p>
                            <p class="info-value">{{ $customer->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="info-label mb-1">{{ __('general.phone_number') }}</p>
                            <p class="info-value">
                                <a href="tel:{{ $customer->phone_number }}" class="text-decoration-none">
                                    <i class="ph-duotone ph-phone me-1"></i> {{ $customer->phone_number }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="info-label mb-1">{{ __('general.source') }}</p>
                            <p class="info-value">
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ \Illuminate\Support\Str::headline($customer->source) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 customer-data-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="ph-duotone ph-clock-counter-clockwise me-2"></i>{{ __('general.customer_timeline') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="info-label mb-1">{{ __('general.created_at') }}</p>
                            <p class="info-value">{{ $customer->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="info-label mb-1">{{ __('general.last_updated') }}</p>
                            <p class="info-value">{{ $customer->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <p class="info-label mb-1">{{ __('general.customer_for') }}</p>
                            <p class="info-value">{{ $customer->created_at->diffForHumans(null, true) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card h-100 customer-data-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="ph-duotone ph-lightning me-2"></i>{{ __('general.quick_actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-outline-primary">
                                <i class="ph-duotone ph-pencil me-2"></i> {{ __('general.edit_customer') }}
                            </a>
                            <a href="tel:{{ $customer->phone_number }}" class="btn btn-outline-success">
                                <i class="ph-duotone ph-phone me-2"></i> {{ __('general.call_customer') }}
                            </a>
                            @if(route('admin.orders.create'))
                                <a href="{{ route('admin.orders.create', ['customer_id' => $customer->id]) }}" class="btn btn-outline-info">
                                    <i class="ph-duotone ph-shopping-cart me-2"></i> {{ __('general.create_new_order') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section (if applicable) -->
        @if(isset($customer->orders) && count($customer->orders) > 0)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card customer-data-card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="ph-duotone ph-shopping-cart me-2"></i>{{ __('general.customer_orders') }}</h5>
                            @if(route('admin.orders.create'))
                                <a href="{{ route('admin.orders.create', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="ph-duotone ph-plus me-1"></i> {{ __('general.new_order') }}
                                </a>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th>{{ __('general.id') }}</th>
                                        <th>{{ __('general.date') }}</th>
                                        <th>{{ __('general.total') }}</th>
                                        <th>{{ __('general.status') }}</th>
                                        <th>{{ __('general.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer->orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">
                                                {{ \Illuminate\Support\Str::headline($order->status) }}
                                            </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
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
        @endif
    </div>

    <!-- Delete Customer Modal -->
    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCustomerModalLabel">{{ __('general.confirm_deletion') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('general.are_you_sure_delete_customer') }} <strong>{{ $customer->name }}</strong>?</p>
                    <p class="text-danger"><small>{{ __('general.action_cannot_be_undone') }}</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('general.cancel') }}</button>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('general.delete_customer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/vendor/select/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/select.js')}}"></script>
    <script>
        // Add any custom JavaScript for the customer show page here
        $(document).ready(function() {
            // Animation for cards
            $('.customer-data-card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
        });
    </script>
@endpush
