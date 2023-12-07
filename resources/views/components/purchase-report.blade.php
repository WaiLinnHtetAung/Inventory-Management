<div class="my-3">
    <h3>Daily Purchase Report For <span class="p-3 bg-info rounded text-white fs-5">{{ $start_date }}</span> - <span
            class="p-3 bg-warning rounded text-white fs-5">{{ $end_date }}</span></h3>
</div>
<table class="table table-bordered table-striped w-100 mt-5">
    <thead>
        <tr>
            <th>{{ __('messages.purchase.fields.date') }}</th>
            <th>{{ __('messages.purchase.fields.invoice_no') }}</th>
            <th>{{ __('messages.purchase.fields.supplier') }}</th>
            <th>{{ __('messages.purchase.fields.product') }}</th>
            <th>{{ __('messages.purchase.fields.qty') }}</th>
            <th>{{ __('messages.purchase.fields.price') }}</th>
            <th>{{ __('messages.purchase.fields.total') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grand_total = 0;
        @endphp
        @foreach ($purchases as $purchase)
            @foreach ($purchase->products as $product)
                @php
                    $grand_total += $product->pivot->total;
                @endphp
                <tr>
                    <td>{{ $purchase->date }}</td>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->supplier->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->qty }}</td>
                    <td>{{ $product->pivot->price }}</td>
                    <td>{{ $product->pivot->total }}</td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="6" class="text-center">Grand Total</td>
            <td>{{ $grand_total }}</td>
        </tr>
    </tbody>
</table>
