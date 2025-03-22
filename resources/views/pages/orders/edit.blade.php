@extends('layouts.master')
@section('title', __('general.edit_order'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select/select2.min.css') }}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ __('general.orders') }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('general.dashboard') }}</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">{{ __('general.orders') }}</a></li>
                    <li class="active">{{ __('general.edit_order') }}</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5>{{ __('general.order_details') }}</h5></div>
                    <div class="card-body">
                        <form id="order-form" action="{{ route('admin.orders.update', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="customer_id">{{ __('general.customer') }}</label>
                                <select id="customer_id" class="form-control select2" name="customer_id" required>
                                    <option value="" disabled>{{ __('general.select_customer') }}</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }} - {{ $customer->phone_number }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="products-container">
                                @foreach ($order->products as $index => $product)
                                    <div class="product-group d-flex align-items-center">
                                        <div class="w-100">
                                            <div class="row my-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">{{ __('general.product') }}</label>
                                                    <select class="form-control select2 product-select" name="products[]" required>
                                                        <option value="" disabled>{{ __('general.select_product') }}</option>
                                                        @foreach ($products as $prod)
                                                            <option value="{{ $prod->id }}" data-price="{{ $prod->price }}" {{ $product->id == $prod->id ? 'selected' : '' }}>{{ $prod->name }} - ${{ number_format($prod->price, 2) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">{{ __('general.quantity') }}</label>
                                                    <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="{{ $product->pivot->quantity }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">{{ __('general.price') }}</label>
                                                    <input type="number" class="form-control price-input" name="prices[]" step="0.01" value="{{ $product->pivot->price }}" required readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">{{ __('general.discount') }}</label>
                                                    <input type="number" class="form-control" name="product_discounts[]" step="0.01" value="{{ $product->pivot->discount }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">{{ __('general.discount_type') }}</label>
                                                    <select class="form-control" name="product_discount_type[]">
                                                        <option value="percentage" {{ $product->pivot->discount_type == 'percentage' ? 'selected' : '' }}>{{ __('general.percentage') }}</option>
                                                        <option value="flat" {{ $product->pivot->discount_type == 'flat' ? 'selected' : '' }}>{{ __('general.flat') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($index > 0)
                                            <button type="button" class="btn-sm btn-danger remove-product mx-2"><i class="ti ti-trash text-white"></i></button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-product" class="btn btn-secondary mt-2">{{ __('general.add_more_products') }}</button>

                            <div class="row my-4">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('general.order_discount') }}</label>
                                    <input type="number" class="form-control" name="order_discount" step="0.01" value="{{ $order->discount }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('general.discount_type') }}</label>
                                    <select class="form-control" name="order_discount_type">
                                        <option value="percentage" {{ $order->discount_type == 'percentage' ? 'selected' : '' }}>{{ __('general.percentage') }}</option>
                                        <option value="flat" {{ $order->discount_type == 'flat' ? 'selected' : '' }}>{{ __('general.flat') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="payment_method">{{ __('general.payment_method') }}</label>
                                    <select id="payment_method" class="form-control" name="payment_method">
                                        <option value="cash" {{ $order->payment_method == 'cash' ? 'selected' : '' }}>{{ __('general.cash') }}</option>
                                        <option value="credit_card" {{ $order->payment_method == 'credit_card' ? 'selected' : '' }}>{{ __('general.credit_card') }}</option>
                                        <option value="bank_transfer" {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>{{ __('general.bank_transfer') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="notes">{{ __('general.order_notes') }}</label>
                                    <textarea id="notes" class="form-control" name="notes" rows="3">{{ $order->notes }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5>{{ __('general.order_summary') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ __('general.subtotal') }}:</td>
                                                        <td class="text-end" id="subtotal">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('general.order_discount') }}:</td>
                                                        <td class="text-end" id="order-discount-amount">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{ __('general.total') }}:</strong></td>
                                                        <td class="text-end"><strong id="total-amount">$0.00</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}">{{ __('general.back') }}</a>
                                <button class="btn btn-primary" type="submit">{{ __('general.update_order') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/select/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // Pre-fill product prices on page load
            $('.product-select').each(function () {
                let selectedOption = $(this).find('option:selected');
                let priceInput = $(this).closest('.row').find('.price-input');

                if (selectedOption.val()) {
                    priceInput.val(selectedOption.data('price'));
                }
            });

            updateOrderSummary();

            // Function to update product price when selected
            $(document).on('change', '.product-select', function() {
                let selectedOption = $(this).find('option:selected');
                let priceInput = $(this).closest('.row').find('.price-input');

                if (selectedOption.val()) {
                    let price = selectedOption.data('price');
                    priceInput.val(price);
                } else {
                    priceInput.val(0);
                }

                updateOrderSummary();
            });

            // Function to update order summary when quantities or discounts change
            $(document).on('change', '.quantity-input, .price-input, [name="product_discounts[]"], [name="product_discount_type[]"], [name="order_discount"], [name="order_discount_type"]', function() {
                updateOrderSummary();
            });

            // Add new product row
            $('#add-product').on('click', function () {
                let newProductGroup = `
                    <div class="product-group d-flex align-items-center">
                        <div class="w-100">
                            <div class="row my-3">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('general.product') }}</label>
                                    <select class="form-control select2 product-select" name="products[]" required>
                                        <option value="" disabled selected>{{ __('general.select_product') }}</option>
                                        @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                                        @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('general.quantity') }}</label>
                <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('general.price') }}</label>
                <input type="number" class="form-control price-input" name="prices[]" step="0.01" value="0" required readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('general.discount') }}</label>
                <input type="number" class="form-control" name="product_discounts[]" step="0.01" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('general.discount_type') }}</label>
                <select class="form-control" name="product_discount_type[]">
                    <option value="percentage">{{ __('general.percentage') }}</option>
                    <option value="flat">{{ __('general.flat') }}</option>
                </select>
            </div>
        </div>
    </div>
    <button type="button" class="btn-sm btn-danger remove-product mx-2"><i class="ti ti-trash text-white"></i></button>
</div>`;

                $('#products-container').append(newProductGroup);
                $('.select2').select2();
            });

            // Remove product row
            $(document).on('click', '.remove-product', function () {
                if ($('.product-group').length > 1) {
                    $(this).closest('.product-group').remove();
                    updateOrderSummary();
                } else {
                    Swal.fire("{{ __('general.error') }}", "{{ __('general.at_least_one_product_required') }}", 'error');
                }
            });

            // Function to calculate order summary
            function updateOrderSummary() {
                let subtotal = 0;

                $('.product-group').each(function() {
                    let quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
                    let price = parseFloat($(this).find('.price-input').val()) || 0;
                    let discount = parseFloat($(this).find('[name="product_discounts[]"]').val()) || 0;
                    let discountType = $(this).find('[name="product_discount_type[]"]').val();

                    let lineTotal = quantity * price;

                    if (discount > 0) {
                        if (discountType === 'percentage') {
                            lineTotal -= (lineTotal * (discount / 100));
                        } else {
                            lineTotal -= discount;
                        }
                    }

                    subtotal += lineTotal;
                });

                let orderDiscount = parseFloat($('[name="order_discount"]').val()) || 0;
                let orderDiscountType = $('[name="order_discount_type"]').val();
                let orderDiscountAmount = 0;

                if (orderDiscount > 0) {
                    if (orderDiscountType === 'percentage') {
                        orderDiscountAmount = subtotal * (orderDiscount / 100);
                    } else {
                        orderDiscountAmount = orderDiscount;
                    }
                }

                let total = subtotal - orderDiscountAmount;

                $('#subtotal').text('$' + subtotal.toFixed(2));
                $('#order-discount-amount').text('$' + orderDiscountAmount.toFixed(2));
                $('#total-amount').text('$' + total.toFixed(2));
            }

            // Form submission for updating order
            $('#order-form').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let submitButton = form.find('button[type="submit"]');

                submitButton.prop('disabled', true).text("{{ __('general.updating') }}");

                let products = [];
                let validForm = true;

                $('.product-group').each(function () {
                    let productId = $(this).find('.product-select').val();
                    let quantity = $(this).find('.quantity-input').val();
                    let price = $(this).find('.price-input').val();

                    if (!productId) {
                        Swal.fire("{{ __('general.error') }}", "{{ __('general.please_select_product') }}", 'error');
                        submitButton.prop('disabled', false).text("{{ __('general.update_order') }}");
                        validForm = false;
                        return false;
                    }

                    if (!quantity || quantity < 1) {
                        Swal.fire("{{ __('general.error') }}", "{{ __('general.please_enter_valid_quantity') }}", 'error');
                        submitButton.prop('disabled', false).text("{{ __('general.update_order') }}");
                        validForm = false;
                        return false;
                    }

                    if (!price || price <= 0) {
                        Swal.fire("{{ __('general.error') }}", "{{ __('general.please_check_price') }}", 'error');
                        submitButton.prop('disabled', false).text("{{ __('general.update_order') }}");
                        validForm = false;
                        return false;
                    }

                    let product = {
                        id: productId,
                        quantity: quantity,
                        price: price,
                        discount: $(this).find('[name="product_discounts[]"]').val(),
                        discount_type: $(this).find('[name="product_discount_type[]"]').val()
                    };
                    products.push(product);
                });

                if (!validForm) return;

                let requestData = {
                    _token: '{{ csrf_token() }}',
                    customer_id: $('#customer_id').val(),
                    products: products,
                    discount: $('[name="order_discount"]').val(),
                    discount_type: $('[name="order_discount_type"]').val(),
                    payment_method: $('#payment_method').val(),
                    notes: $('#notes').val(),
                };

                $.ajax({
                    url: form.attr('action'),
                    type: "PUT",
                    contentType: "application/json",
                    data: JSON.stringify(requestData),
                    success: function (response) {
                        submitButton.prop('disabled', false).text("{{ __('general.update_order') }}");

                        Swal.fire({
                            title: "{{ __('general.success') }}!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "{{ __('general.view_order') }}",
                        }).then((result) => {
                            if (result.isConfirmed && response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                window.location.href = "{{ route('admin.orders.index') }}";
                            }
                        });
                    },
                    error: function (xhr) {
                        let error = xhr.responseJSON?.message || "{{ __('general.something_went_wrong') }}";

                        Swal.fire("{{ __('general.error') }}", error, "error");

                        submitButton.prop('disabled', false).text("{{ __('general.update_order') }}");
                    }
                });
            });
        });
    </script>
@endpush
