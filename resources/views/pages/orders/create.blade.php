@extends('layouts.master')
@section('title', 'Add New Order')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select/select2.min.css') }}">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">Orders</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="active">Add New Order</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5>Order Details</h5></div>
                    <div class="card-body">
                        <form id="order-form" action="{{ route('admin.orders.store') }}" method="post">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="customer_id">Customer</label>
                                <select id="customer_id" class="form-control select2" name="customer_id" required>
                                    <option value="" disabled selected>Select a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone_number }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="products-container">
                                <div class="product-group d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="row my-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Product</label>
                                                <select class="form-control select2 product-select" name="products[]" required>
                                                    <option value="" disabled selected>Select a product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Price</label>
                                                <input type="number" class="form-control price-input" name="prices[]" step="0.01" value="0" required readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Discount</label>
                                                <input type="number" class="form-control" name="product_discounts[]" step="0.01" value="0">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Discount Type</label>
                                                <select class="form-control" name="product_discount_type[]">
                                                    <option value="percentage">Percentage</option>
                                                    <option value="flat">Flat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-sm btn-danger remove-product mx-2"><i class="ti ti-trash text-white"></i></button>
                                </div>
                            </div>
                            <button type="button" id="add-product" class="btn btn-secondary mt-2">Add More Products</button>

                            <div class="row my-4">
                                <div class="col-md-6">
                                    <label class="form-label">Order Discount</label>
                                    <input type="number" class="form-control" name="order_discount" step="0.01" value="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Discount Type</label>
                                    <select class="form-control" name="order_discount_type">
                                        <option value="percentage">Percentage</option>
                                        <option value="flat">Flat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="payment_method">Payment Method</label>
                                    <select id="payment_method" class="form-control" name="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="notes">Order Notes</label>
                                    <textarea id="notes" class="form-control" name="notes" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5>Order Summary</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>Subtotal:</td>
                                                        <td class="text-end" id="subtotal">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Order Discount:</td>
                                                        <td class="text-end" id="order-discount-amount">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Total:</strong></td>
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
                                <a class="btn btn-secondary" href="{{ route('admin.orders.index') }}">Back</a>
                                <button class="btn btn-primary" type="submit">Save Order</button>
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
                                    <label class="form-label">Product</label>
                                    <select class="form-control select2 product-select" name="products[]" required>
                                        <option value="" disabled selected>Select a product</option>
                                        @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                                        @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Price</label>
                <input type="number" class="form-control price-input" name="prices[]" step="0.01" value="0" required readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Discount</label>
                <input type="number" class="form-control" name="product_discounts[]" step="0.01" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Discount Type</label>
                <select class="form-control" name="product_discount_type[]">
                    <option value="percentage">Percentage</option>
                    <option value="flat">Flat</option>
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
                    Swal.fire('Error', 'At least one product is required.', 'error');
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

                submitButton.prop('disabled', true).text('Updating...');

                let products = [];
                let validForm = true;

                $('.product-group').each(function () {
                    let productId = $(this).find('.product-select').val();
                    let quantity = $(this).find('.quantity-input').val();
                    let price = $(this).find('.price-input').val();

                    if (!productId) {
                        Swal.fire('Error', 'Please select a product.', 'error');
                        submitButton.prop('disabled', false).text('Update Order');
                        validForm = false;
                        return false;
                    }

                    if (!quantity || quantity < 1) {
                        Swal.fire('Error', 'Please enter a valid quantity for all products.', 'error');
                        submitButton.prop('disabled', false).text('Update Order');
                        validForm = false;
                        return false;
                    }

                    if (!price || price <= 0) {
                        Swal.fire('Error', 'Please check the price for all products.', 'error');
                        submitButton.prop('disabled', false).text('Update Order');
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
                        submitButton.prop('disabled', false).text('Create Order');

                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "View Order",
                        }).then((result) => {
                            if (result.isConfirmed && response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                window.location.href = "{{ route('admin.orders.index') }}";
                            }
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr)
                        Swal.fire("Error", xhr.message, "error");
                        submitButton.prop('disabled', false).text('Create Order');
                    }
                });
            });
        });
    </script>
@endpush
