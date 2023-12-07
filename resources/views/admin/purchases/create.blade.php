@extends('layouts.app')
@section('title', 'Create Purchase')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart-alt' style="color: rgb(207, 122, 10);"></i>
        <div>{{ __('messages.purchase.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-5">{{ __('messages.purchase.title') }} Creation</span>

        <form action="{{ route('admin.purchases.store') }}" method="post" id="purchase_create">
            @csrf
            <div class="row mb-4">
                <div class="col-4 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.purchase.fields.invoice_no') }}</label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ $invoice_no }}" readonly>
                    </div>
                </div>

                <div class="col-8 col-md-6">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.purchase.fields.supplier') }}</label>
                        <select name="supplier_id" id="" class="form-control select2"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($suppliers as $key => $value)
                                <option value="{{ $key }}" {{ old('supplier_id') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.purchase.fields.date') }}</label>
                        <input type="date" name="date" class="form-control date" placeholder="YYYY-MM-DD"
                            value="{{ old('date') }}">
                    </div>
                </div>
            </div>

            {{-- Multi row  --}}
            <div class="row border-bottom mb-3">
                <div class="col-4 col-md-3 mb-3 ">
                    <label for="">{{ __('messages.purchase.fields.product') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.purchase.fields.qty') }}</label>
                </div>
                <div class="col-1 mb-3">
                    <label for="">{{ __('messages.purchase.fields.currency') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.purchase.fields.price') }}</label>
                </div>
                <div class="col-2 mb-3">
                    <label for="">{{ __('messages.purchase.fields.total') }}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                    <select name="product_id1" id="" class="form-control select2"
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
                    <select name="currency1" class="form-select bg-info text-white" id="">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePurchaseRequest', '#purchase_create') !!}

    <script>
        $(document).ready(function() {
            let rowCount = 1;

            //add product
            $(document).on('click', '.add', function() {
                ++rowCount;
                let newProduct = `
                <div class="row productRow${rowCount}">
                    <div class="col-4 col-md-3 mb-2 me-0 pe-1">
                        <select name="product_id${rowCount}" id="" class="form-select select2" required>
                            <option value="">Please Select</option>
                            @foreach ($products as $key => $value)
                                <option value="{{ $key }}" {{ old('product_id') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2  mb-2 me-0 pe-1">
                        <input type="number" name="qty${rowCount}" class="form-control qty" required>
                    </div>
                    <div class="col-1  mb-2 me-0 pe-1">
                        <select name="currency${rowCount}" class="form-select bg-info text-white" id="" required>
                            <option value="MMK">MMK</option>
                            <option value="USD">USD</option>
                            <option value="THB">THB</option>
                        </select>
                    </div>
                    <div class="col-2  mb-2 me-0 pe-1">
                        <input type="number" name="price${rowCount}" class="form-control price" required>
                    </div>
                    <div class="col-2  mb-2 me-0 pe-1">
                        <input type="number" name="total${rowCount}" readonly class="form-control total" required>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center gap-3 mb-2">
                        <i class='bx bxs-plus-circle fs-3 text-primary cursor-pointer add' data-count=${rowCount}></i>
                        <i class='bx bxs-minus-circle fs-3 text-danger cursor-pointer remove' data-count=${rowCount}></i>
                    </div>
                    <input type="hidden" name="rowCount" value="${rowCount}">
                </div>
                `;
                $('#more-item').append(newProduct);
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
        })
    </script>

@endsection
