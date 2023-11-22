@extends('layouts.app')
@section('title', 'Create Edit')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-dollar-circle' style="color: green;"></i>
        <div>{{ __('messages.sale.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-5">{{ __('messages.sale.title') }} Edition</span>

        <form action="{{ route('admin.sales.update', $sale->id) }}" method="post" id="sale_edit">
            @csrf
            @method('PUT')
            <div class="row mb-4">
                <div class="col-4 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.invoice_no') }}</label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ $sale->invoice_no }}"
                            readonly>
                    </div>
                </div>

                <div class="col-8 col-md-6">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.customer') }}</label>
                        <select name="customer_id" id="" class="form-control select2"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($customers as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('customer_id') || $sale->customer_id == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.date') }}</label>
                        <input type="date" name="date" class="form-control date" placeholder="YYYY-MM-DD"
                            value="{{ $sale->date }}">
                    </div>
                </div>
            </div>

            {{-- Multi row  --}}
            <div class="row border-bottom mb-3">
                <div class="col-4 col-md-3 mb-3 ">
                    <label for="">{{ __('messages.sale.fields.product') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.sale.fields.qty') }}</label>
                </div>
                <div class="col-1 mb-3">
                    <label for="">{{ __('messages.sale.fields.currency') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.sale.fields.price') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.sale.fields.total') }}</label>
                </div>
            </div>
            @foreach ($sale->products as $product)
                <div class="row">
                    <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                        <select name="product_id{{ $loop->iteration }}" id="" class="form-control select2 product"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($products as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('product_id') || $product->id == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="qty{{ $loop->iteration }}" class="form-control qty"
                            value="{{ $product->pivot->qty }}">

                        <input type="hidden" name="old_qty{{ $loop->iteration }}" value="{{ $product->pivot->qty }}">
                    </div>
                    <div class="col-1 mb-2 me-0 pe-1">
                        <select name="currency{{ $loop->iteration }}" class="form-select bg-info text-white currency"
                            id="">
                            <option value="MMK" {{ $product->pivot->currency == 'MMK' ? 'selected' : '' }}>MMK</option>
                            <option value="USD" {{ $product->pivot->currency == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="THB" {{ $product->pivot->currency == 'THB' ? 'selected' : '' }}>THB</option>
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="price{{ $loop->iteration }}" class="form-control price"
                            value="{{ $product->pivot->price }}">
                    </div>
                    <div class="col-2 mb-3 me-0 pe-1">
                        <input type="number" class="form-control total" name="total{{ $loop->iteration }}"
                            value="{{ $product->pivot->total }}" readonly>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center gap-3 mb-2">
                        <i class='bx bxs-plus-circle fs-3 text-primary cursor-pointer add'></i>
                        <i class='bx bxs-minus-circle fs-3 text-danger cursor-pointer remove'></i>
                    </div>
                    <input type="hidden" name="rowCount" value="{{ $loop->iteration }}">
                </div>
            @endforeach
            <div id="more-item"></div>
            <div class="row mt-3">
                <div class="col-2 offset-6 text-center pt-2">
                    <span>Grand Total</span>
                </div>
                <div class="col-2">
                    <input type="number" readonly name="grand_total" class="form-control grand-total"
                        value="{{ $sale->grand_total }}">
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateSaleRequest', '#sale_edit') !!}

    <script>
        $(document).ready(function() {
            let oldRowCount = {!! count($sale->products) !!}
            let newRowCount = 0;

            //get stock and price on each product
            $(document).on('change', '.product', function() {
                let product_id = $(this).val();
                let row = $(this).closest('.row');
                $.ajax({
                    url: "{{ route('admin.product.stock') }}",
                    type: "POST",
                    data: {
                        product_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        let stock = res.stock;
                        row.find('.qty').attr('placeholder', 'Stock ' + stock);
                        row.find('.price').val(res.price);
                        row.find('.currency').val(res.currency);
                    }
                })
            })

            //compare stock
            $(document).on('input', '.qty', function() {
                let qty = $(this).val();
                let row = $(this).closest('.row');
                let product_id = row.find('.product').val();

                if (product_id) {
                    if (product_id && qty) {
                        $.ajax({
                            url: "{{ route('admin.compare.stock') }}",
                            type: "POST",
                            data: {
                                qty,
                                product_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status == 'exceed') {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: res.message,
                                    });
                                    row.find('.qty').val('');
                                }
                            }
                        })
                    }
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Oops...",
                        text: "Please select product first !",
                    });

                    row.find('.qty').val('');
                }


            })

            //add multi row
            $(document).on('click', '.add', function() {
                ++newRowCount;
                let new_product = `
                <div class="row productRow${newRowCount}">
                    <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                        <select name="new_product_id${newRowCount}" id="" class="form-select product"
                            data-placeholder="--- Please Select ---">
                            <option value="">Please Select</option>
                            @foreach ($products as $key => $value)
                                <option value="{{ $key }}" {{ old('product_id') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="new_qty${newRowCount}" class="form-control qty">
                    </div>
                    <div class="col-1 mb-2 me-0 pe-1">
                        <select name="new_currency${newRowCount}" class="form-select bg-info text-white currency" id="">
                            <option value="MMK">MMK</option>
                            <option value="USD">USD</option>
                            <option value="THB">THB</option>
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="new_price${newRowCount}" class="form-control price">
                    </div>
                    <div class="col-2 mb-3 me-0 pe-1">
                        <input type="number" class="form-control total" name="new_total${newRowCount}" readonly>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center gap-3 mb-2">
                        <i class='bx bxs-plus-circle fs-3 text-primary cursor-pointer add' data-count=${newRowCount}></i>
                        <i class='bx bxs-minus-circle fs-3 text-danger cursor-pointer remove' data-count=${newRowCount}></i>
                    </div>
                    <input type="hidden" name="newRowCount" value="${newRowCount}">
                </div>
                `;

                $('#more-item').append(new_product);
            })

            //remove product
            $(document).on('click', '.remove', function() {
                let count = $(this).data('count');
                $('.productRow' + count).remove();

                // grand total
                let oldTotal = 0;
                let newTotal = 0;
                for (let i = 1; i <= oldRowCount; i++) {
                    oldTotal += parseInt($(`input[name='total${i}']`).val());
                }
                for (let j = 1; j <= newRowCount; j++) {
                    let amount = $(`input[name='new_total${j}']`).val() ? $(`input[name='new_total${j}']`)
                        .val() : 0;
                    newTotal += parseInt(amount);
                }
                $('.grand-total').val(oldTotal + newTotal);
            })

            //calculate total amount (price input)
            $(document).on('input', '.price', function() {
                //total with qty
                let row = $(this).closest('.row');
                let qty = parseInt(row.find('.qty').val()) || 0;
                let price = parseInt(row.find('.price').val()) || 0;
                row.find('.total').val(qty * price)

                // grand total
                let oldTotal = 0;
                let newTotal = 0;
                for (let i = 1; i <= oldRowCount; i++) {
                    oldTotal += parseInt($(`input[name='total${i}']`).val());
                }
                for (let j = 1; j <= newRowCount; j++) {
                    let amount = $(`input[name='new_total${j}']`).val() ? $(`input[name='new_total${j}']`)
                        .val() : 0;
                    newTotal += parseInt(amount);
                }
                $('.grand-total').val(oldTotal + newTotal);
            })

            //calculate total amount (qty input)
            $(document).on('input', '.qty', function() {
                //total with qty
                let row = $(this).closest('.row');
                let qty = parseInt(row.find('.qty').val()) || 0;
                let price = parseInt(row.find('.price').val()) || 0;
                row.find('.total').val(qty * price)

                // grand total
                let oldTotal = 0;
                let newTotal = 0;
                for (let i = 1; i <= oldRowCount; i++) {
                    oldTotal += parseInt($(`input[name='total${i}']`).val());
                }
                for (let j = 1; j <= newRowCount; j++) {
                    let amount = $(`input[name='new_total${j}']`).val() ? $(`input[name='new_total${j}']`)
                        .val() : 0;
                    newTotal += parseInt(amount);
                }
                $('.grand-total').val(oldTotal + newTotal);
            })
        })
    </script>
@endsection
