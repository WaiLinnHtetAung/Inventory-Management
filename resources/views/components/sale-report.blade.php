<div class="my-3">
    <h3>Daily Sale Report For <span class="p-3 bg-info rounded text-white fs-5">{{ $start_date }}</span> - <span
            class="p-3 bg-warning rounded text-white fs-5">{{ $end_date }}</span></h3>
</div>
<table class="table table-bordered table-striped w-100 mt-5">
    <thead>
        <tr>
            <th>{{ __('messages.sale.fields.date') }}</th>
            <th>{{ __('messages.sale.fields.invoice_no') }}</th>
            <th>{{ __('messages.sale.fields.customer') }}</th>
            <th>{{ __('messages.sale.fields.product') }}</th>
            <th>{{ __('messages.sale.fields.qty') }}</th>
            <th>{{ __('messages.sale.fields.price') }}</th>
            <th>{{ __('messages.sale.fields.total') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grand_total = 0;
        @endphp
        @foreach ($sales as $sale)
            @foreach ($sale->products as $product)
                @php
                    $grand_total += $product->pivot->total;
                @endphp
                <tr>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->customer->name }}</td>
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
