@extends('layouts.app')
@section('title', 'Create Purchase')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-menu-alt-right' style="color: rgb(3, 23, 202);"></i>
        <div>{{ __('messages.purchase.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.purchase.title') }} Creation</span>

        <form action="{{ route('admin.categories.store') }}" method="post" id="purchase_create">
            @csrf
            <div class="row">
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
                        <label for="">{{ __('messages.purchase.fields.supplier') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>

            </div>
            <div class="mt-3">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePurchaseRequest', '#purchase_create') !!}

@endsection
