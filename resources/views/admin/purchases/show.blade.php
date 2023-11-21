@extends('layouts.app')
@section('title', 'Purchase Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart-alt' style="color: rgb(207, 122, 10);"></i>
        <div>{{ __('messages.purchase.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3 mb-5">
            <span>{{ __('messages.purchase.title') }} Detail</span>
        </div>
        <div class="card-body">
            <table style="width: 100%" class="mb-5">
                <tr>
                    <td>
                        <h2 class="fw-bold mb-4">Purchase Invoice</h2>
                        <div class="row mb-2">
                            <div class="col-2">{{ __('messages.purchase.fields.invoice_no') }}</div>
                            <div class="col-6">: {{ $purchase->invoice_no }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2">{{ __('messages.purchase.fields.date') }}</div>
                            <div class="col-6">: {{ \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2">{{ __('messages.purchase.fields.supplier') }}</div>
                            <div class="col-6 fw-bold fs-5">: {{ $purchase->supplier->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">{{ __('messages.purchase.fields.supplier_email') }}</div>
                            <div class="col-6">: {{ $purchase->supplier->email }}</div>
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-block text-center">
                            <img src="{{ asset('logo.png') }}" alt="company logo" width="150">
                            <h2 class="fw-bold">{{ __('messages.panel_name') }}</h2>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table table-responsive">
                <tr class="bg-primary">
                    <th class="text-white">No</th>
                    <th class="text-white">{{ __('messages.purchase.fields.product') }}</th>
                    <th class="text-white">{{ __('messages.purchase.fields.qty') }}</th>
                    <th class="text-white">{{ __('messages.purchase.fields.currency') }}</th>
                    <th class="text-white">{{ __('messages.purchase.fields.price') }}</th>
                    <th class="text-white">{{ __('messages.purchase.fields.total') }}</th>
                </tr>
                @foreach ($purchase->products as $key => $product)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->qty }}</td>
                        <td>{{ $product->pivot->currency }}</td>
                        <td>{{ $product->pivot->price }}</td>
                        <td>{{ $product->pivot->total }}</td>
                    </tr>
                @endforeach
                <tr style="background: rgb(245, 240, 240);">
                    <td colspan="5" class="text-center">{{ __('messages.purchase.fields.grand-total') }}</td>
                    <td>{{ $purchase->grand_total }}</td>
                </tr>
            </table>
            <button class="btn btn-outline-secondary mt-5 back-btn">Back to List</button>
        </div>
    </div>
@endsection
