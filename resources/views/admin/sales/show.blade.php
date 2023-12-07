@extends('layouts.app')
@section('title', 'Sale Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-dollar-circle' style="color: green;"></i>
        <div>{{ __('messages.sale.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3 mb-5">
            <span>{{ __('messages.sale.title') }} Detail</span>
            <div>
                <i class='bx bxs-printer fs-1 me-3 text-success cursor-pointer' onclick="printFunction();"></i>
                <a href="{{ route('admin.pdf.download', ['pdf' => $sale->id, 'type' => 'sale']) }}"><i
                        class='bx bxs-download fs-1 me-5 text-danger cursor-pointer'></i></a>
            </div>
        </div>
        <div class="card-body" id="print_div">
            <table style="width: 100%" class="mb-5 upper-table">
                <tr>
                    <td style="width: 70%;">
                        <h2 class="fw-bold mb-4">Sale Invoice</h2>
                        <div class="row mb-2">
                            <div class="col-4 col-md-3">{{ __('messages.sale.fields.invoice_no') }}</div>
                            <div class="col-6">: {{ $sale->invoice_no }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 col-md-3">{{ __('messages.sale.fields.date') }}</div>
                            <div class="col-6">: {{ \Carbon\Carbon::parse($sale->date)->format('d-m-Y') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 col-md-3">{{ __('messages.sale.fields.customer') }}</div>
                            <div class="col-6 fs-5">: {{ $sale->customer->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 col-md-3">{{ __('messages.sale.fields.customer_email') }}</div>
                            <div class="col-6">: {{ $sale->customer->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 col-md-3">{{ __('messages.sale.fields.customer_address') }}</div>
                            <div class="col-6">: {{ $sale->customer->address }}</div>
                        </div>
                    </td>
                    <td class="text-end" style="width:28%;">
                        <div class="d-inline-block text-center">
                            <img src="{{ asset('logo.png') }}" alt="company logo" width="150">
                            <h3 class="fw-bold">{{ __('messages.panel_name') }}</h3>
                            <p>No.23B, Thamardi 2dn St, Thingangyun, Yangon</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table table-responsive lower-table">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-white">No</th>
                        <th class="text-white">{{ __('messages.sale.fields.product') }}</th>
                        <th class="text-white">{{ __('messages.sale.fields.qty') }}</th>
                        <th class="text-white">{{ __('messages.sale.fields.currency') }}</th>
                        <th class="text-white">{{ __('messages.sale.fields.price') }}</th>
                        <th class="text-white">{{ __('messages.sale.fields.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->products as $key => $product)
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
                        <td colspan="5" class="text-center">{{ __('messages.sale.fields.grand-total') }}</td>
                        <td>{{ $sale->grand_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-5">
            <button class="btn btn-outline-secondary mt-5 back-btn">Back to List</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function printFunction() {
            var contents = $("#print_div").html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({
                "position": "absolute",
                "top": "-1000000px"
            });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[
                0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>Inventory Management</title>');
            //Append the internal CSS file.
            frameDoc.document.write(`
                                    <style>
                                        .card-body{
                                            border: 0px !important;
                                        }

                                        @media print {
                                            * {
                                                margin: 0;
                                                padding: 0;
                                            }

                                            body {
                                                background: rgb(245, 239, 239);
                                                padding: 30px;
                                            }

                                            .upper-table {
                                                margin-top: 80px !important;
                                                margin-bottom: 30px !important;
                                            }

                                            .upper-table tr td .row div {
                                                height: 30px;
                                            }

                                            .lower-table tr th, .lower-table tr td {
                                                height: 40px;
                                            }

                                            .lower-table thead tr {
                                                background: #99e099 !important;
                                                -webkit-print-color-adjust: exact;
                                            }

                                            .lower-table thead tr th {
                                                color: #333 !important;
                                            }

                                            .lower-table tbody tr:nth-child(even) {
                                                background: #d1cece;
                                                -webkit-print-color-adjust: exact;
                                            }
                                        }

                                    </style>
                                    `);
            //bootstrap link
            frameDoc.document.write(
                '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">'
            );
            frameDoc.document.write('</head><body>');
            //Append the DIV contents.
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            var curURL = window.location.href;
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                history.replaceState(history.state, '', '/');
                window.frames["frame1"].print();
                history.replaceState(history.state, '', curURL);
                frame1.remove();
            }, 200);
        }
    </script>
@endsection
