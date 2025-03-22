@extends('layouts.master')
@section('title', __('general.order_details'))

@push('css')
    <style>
        .order-status {
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
        }
        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }
        .status-processing {
            background-color: #D1ECF1;
            color: #0C5460;
        }
        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }
        .status-cancelled {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .payment-paid {
            background-color: #D4EDDA;
            color: #155724;
        }
        .payment-pending {
            background-color: #FFF3CD;
            color: #856404;
        }
        .payment-partial {
            background-color: #D1ECF1;
            color: #0C5460;
        }
        .table th {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.orders') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('general.dashboard') }}</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">{{ __('general.orders') }}</a></li>
                    <li class="active">{{ __('general.order_details') }}</li>
                </ul>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('general.order_number') }} #{{ $order->order_number }}</h5>
                    <div>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary me-2">
                            <i class="ti ti-edit"></i> {{ __('general.edit_order') }}
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i> {{ __('general.actions') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item print-order" href="javascript:void(0)">
                                        <i class="ti ti-printer"></i> {{ __('general.print_order') }}
                                    </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="ti ti-trash"></i> {{ __('general.delete_order') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Products -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('general.order_items') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>{{ __('general.product') }}</th>
                                    <th class="text-center">{{ __('general.price') }}</th>
                                    <th class="text-center">{{ __('general.quantity') }}</th>
                                    <th class="text-center">{{ __('general.discount') }}</th>
                                    <th class="text-end">{{ __('general.total') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderProducts as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ $item->product ? $item->product->name : __('general.unknown_product') }}</strong>
                                                    @if($item->product && $item->product->sku)
                                                        <div class="small text-muted">SKU: {{ $item->product->sku }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">
                                            @if($item->discount > 0)
                                                @if($item->discount_type == 'percentage')
                                                    {{ $item->discount }}%
                                                @else
                                                    ${{ number_format($item->discount, 2) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">${{ number_format($item->price * $item->quantity - ($item->discount_type == 'percentage' ? ($item->price * $item->quantity * $item->discount / 100) : $item->discount), 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>{{ __('general.subtotal') }}:</strong></td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>{{ __('general.order_discount') }}:</strong></td>
                                    <td class="text-end">
                                        @if($order->discount > 0)
                                            @if($order->discount_type == 'percentage')
                                                {{ $order->discount }}% (${{ number_format($order->subtotal * $order->discount / 100, 2) }})
                                            @else
                                                ${{ number_format($order->discount, 2) }}
                                            @endif
                                        @else
                                            $0.00
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>{{ __('general.total') }}:</strong></td>
                                    <td class="text-end"><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                @if($order->notes)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('general.order_notes') }}</h5>
                        </div>
                        <div class="card-body">
                            {{ $order->notes }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Order Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('general.order_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">

                            <tr>
                                <th>{{ __('general.payment_method') }}:</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('general.order_date') }}:</th>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @if($order->updated_at->ne($order->created_at))
                                <tr>
                                    <th>{{ __('general.last_updated') }}:</th>
                                    <td>{{ $order->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('general.customer_information') }}</h5>
                        @if($order->customer)
                            <a href="{{ route('admin.customers.show', $order->customer->id) }}" class="btn btn-sm btn-outline-primary">{{ __('general.view_profile') }}</a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($order->customer)
                            <div class="d-flex align-items-center mb-3">
                                @if($order->customer->avatar)
                                    <img src="{{ asset($order->customer->avatar) }}" alt="{{ $order->customer->name }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                        <i class="ti ti-user fs-3"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $order->customer->name }}</h5>
                                    <p class="text-muted mb-0">{{ __('general.customer_since') }} {{ $order->customer->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                            <hr>

                            @if($order->customer->phone_number)
                                <div class="mb-2">
                                    <i class="ti ti-phone me-2"></i> {{ $order->customer->phone_number }}
                                </div>
                            @endif
                            @if($order->customer->address)
                                <div>
                                    <i class="ti ti-map-pin me-2"></i> {{ $order->customer->address }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-3">
                                <i class="ti ti-user-off fs-1 text-muted"></i>
                                <p class="mt-2">{{ __('general.customer_info_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Delete order confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: "{{ __('general.are_you_sure') }}",
                    text: "{{ __('general.order_delete_permanent') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "{{ __('general.yes_delete') }}",
                    cancelButtonText: "{{ __('general.cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Print Order
            $('.print-order').on('click', function() {
                window.print();
            });
        });
    </script>
@endpush
