@extends('layouts.app')
@section('title', 'Create Sale')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-dollar-circle' style="color: green;"></i>
        <div>{{ __('messages.sale.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-5">{{ __('messages.sale.title') }} Creation</span>

        <form action="{{ route('admin.sales.store') }}" method="post" id="sale_create">
            @csrf
            <div class="row mb-4">
                <div class="col-4 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.invoice_no') }}</label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ $invoice_no }}" readonly>
                    </div>
                </div>

                <div class="col-8 col-md-6">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.customer') }}</label>
                        <div class="input-group">
                            <select name="customer_id" id="" class="form-control select2 customer-select"
                                data-placeholder="--- Please Select ---">
                                <option value=""></option>
                                @foreach ($customers as $key => $value)
                                    <option value="{{ $key }}" {{ old('customer_id') == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-danger rounded-end" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class='bx bx-plus fs-5'></i>
                            </button>

                            {{-- New Supplier Modal  --}}
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <hr>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control name"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" name="email" class="form-control email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Phone</label>
                                                        <input type="text" name="phone" class="form-control phone">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Address <span
                                                                class="text-danger">*</span></label>
                                                        <textarea name="address" id="" cols="30" rows=5" class="form-control address" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary add-customer">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.sale.fields.date') }}</label>
                        <input type="date" name="date" class="form-control date" placeholder="YYYY-MM-DD"
                            value="{{ old('date') }}">
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
            <div class="row">
                <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                    <select name="product_id1" id="" class="form-control select2 product"
                        data-placeholder="--- Please Select ---">
                        <option value=""></option>
                        @foreach ($products as $key => $value)
                            <option value="{{ $key }}" {{ old('product_id') == $key ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 mb-2 me-0 pe-1">
                    <input type="number" name="qty1" class="form-control qty">
                </div>
                <div class="col-1 mb-2 me-0 pe-1">
                    <select name="currency1" class="form-select bg-info text-white currency" id="">
                        <option value="MMK">MMK</option>
                        <option value="USD">USD</option>
                        <option value="THB">THB</option>
                    </select>
                </div>
                <div class="col-2 mb-2 me-0 pe-1">
                    <input type="number" name="price1" class="form-control price">
                </div>
                <div class="col-2 mb-3 me-0 pe-1">
                    <input type="number" class="form-control total" name="total1" readonly>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-center gap-3 mb-2">
                    <i class='bx bxs-plus-circle fs-3 text-primary cursor-pointer add'></i>
                    <i class='bx bxs-minus-circle fs-3 text-danger cursor-pointer remove'></i>
                </div>
                <input type="hidden" name="rowCount" value="1">
            </div>
            <div id="more-item"></div>
            <div class="row mt-3">
                <div class="col-2 offset-6 text-center pt-2">
                    <span>Grand Total</span>
                </div>
                <div class="col-2">
                    <input type="number" readonly name="grand_total" class="form-control grand-total">
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreSaleRequest', '#sale_create') !!}

    <script>
        $(document).ready(function() {
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
            let rowCount = 1;
            $(document).on('click', '.add', function() {
                ++rowCount;
                let new_product = `
                <div class="row productRow${rowCount}">
                    <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                        <select name="product_id${rowCount}" id="" class="form-select product"
                            data-placeholder="--- Please Select ---">
                            <option value="">Please Select</option>
                            @foreach ($products as $key => $value)
                                <option value="{{ $key }}" {{ old('product_id') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="qty${rowCount}" class="form-control qty">
                    </div>
                    <div class="col-1 mb-2 me-0 pe-1">
                        <select name="currency${rowCount}" class="form-select bg-info text-white currency" id="">
                            <option value="MMK">MMK</option>
                            <option value="USD">USD</option>
                            <option value="THB">THB</option>
                        </select>
                    </div>
                    <div class="col-2 mb-2 me-0 pe-1">
                        <input type="number" name="price${rowCount}" class="form-control price">
                    </div>
                    <div class="col-2 mb-3 me-0 pe-1">
                        <input type="number" class="form-control total" name="total${rowCount}" readonly>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center gap-3 mb-2">
                        <i class='bx bxs-plus-circle fs-3 text-primary cursor-pointer add' data-count=${rowCount}></i>
                        <i class='bx bxs-minus-circle fs-3 text-danger cursor-pointer remove' data-count=${rowCount}></i>
                    </div>
                    <input type="hidden" name="rowCount" value="${rowCount}">
                </div>
                `;

                $('#more-item').append(new_product);
            })

            //remove product
            $(document).on('click', '.remove', function() {
                let count = $(this).data('count');
                $('.productRow' + count).remove();

                // grand total
                let total = 0;
                for (let i = 1; i <= rowCount; i++) {
                    let amount = $(`input[name='total${i}']`).val() ? $(`input[name='total${i}']`).val() :
                        0;
                    total += parseInt(amount);
                }
                $('.grand-total').val(total);
            })

            //calculate total amount (price input)
            $(document).on('input', '.price', function() {
                //total with qty
                let row = $(this).closest('.row');
                let qty = parseInt(row.find('.qty').val()) || 0;
                let price = parseInt(row.find('.price').val()) || 0;
                row.find('.total').val(qty * price)

                // grand total
                let total = 0;
                for (let i = 1; i <= rowCount; i++) {
                    let amount = $(`input[name='total${i}']`).val() ? $(`input[name='total${i}']`).val() :
                        0;
                    total += parseInt(amount);
                }
                $('.grand-total').val(total);
            })

            //calculate total amount (qty input)
            $(document).on('input', '.qty', function() {
                //total with qty
                let row = $(this).closest('.row');
                let qty = parseInt(row.find('.qty').val()) || 0;
                let price = parseInt(row.find('.price').val()) || 0;
                row.find('.total').val(qty * price)

                // grand total
                let total = 0;
                for (let i = 1; i <= rowCount; i++) {
                    let amount = $(`input[name='total${i}']`).val() ? $(`input[name='total${i}']`).val() :
                        0;
                    total += parseInt(amount);
                }
                $('.grand-total').val(total);
            })

            //add new customer
            $(document).on('click', '.add-customer', function() {
                let name = $('.name').val();
                let email = $('.email').val();
                let phone = $('.phone').val();
                let address = $('.address').val();

                if (!name || !address) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please fill required fields !",
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.customer-from-sale') }}",
                        data: {
                            name,
                            email,
                            phone,
                            address,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            let option = `<option value="${res.id}">${res.name}</option>`;

                            $('.customer-select').append(option);
                            $('.modal').modal('hide');
                        }
                    })
                }
            })
        })
    </script>
@endsection
