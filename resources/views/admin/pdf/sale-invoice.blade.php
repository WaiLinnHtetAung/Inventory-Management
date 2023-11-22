<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background: rgb(245, 239, 239);
            padding: 30px;
        }

        .head {
            margin-top: 40px;
        }

        .head .info {
            display: inline-block;
            margin-top: 40px;
        }

        .head .logo {
            float: right;
        }

        .table1 tr td {
            height: 30px;
        }

        .table2 {
            margin-top: 100px;
            width: 100%;
            border-collapse: collapse;
        }

        .table2 th,
        .table2 td {
            height: 40px;
            text-align: center;
        }

        .table2 tbody tr:nth-child(even) {
            background: #d1cece;
        }
    </style>
</head>

<body>
    <div class="head">
        <div class="info">
            <h2 style="margin-bottom: 10px;">Purchase Invoice</h2>
            <table class="table1">
                <tr>
                    <td style="width: 150px;">Invoice No.</td>
                    <td>:&nbsp;{{ $invoice_no }}</td>
                </tr>
                <tr>
                    <td style="width: 150px;">Date</td>
                    <td>:&nbsp;{{ $date }}</td>
                </tr>
                <tr>
                    <td style="width: 150px;">Customer Name</td>
                    <td>:&nbsp;<b>{{ $customer_name }}</b></td>
                </tr>
                <tr>
                    <td style="width: 150px;">Customer Email</td>
                    <td>:&nbsp;{{ $customer_email }}</td>
                </tr>
            </table>
        </div>
        <div class="logo">
            <img style="margin-left: 130px;" src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/logo.png'))); ?>" width="150">
            <h2 style="margin-left: 90px;">Invoice Management</h2>
            <p style="text-align: center; margin-left: 50px;">No 23B, Thamarde 2nd St, Thingangyun, <br> Yangon</p>
        </div>
    </div>

    <table class="table2">
        <thead>
            <tr style="background: #99e099;">
                <th>No</th>
                <th>Products</th>
                <th>Qty</th>
                <th>Currency</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total = 0;
            @endphp
            @foreach ($products as $product)
                @php
                    $grand_total += $product->pivot->total;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->qty }}</td>
                    <td>{{ $product->pivot->currency }}</td>
                    <td>{{ $product->pivot->price }}</td>
                    <td>{{ $product->pivot->total }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style="background: transparent;">
                <td colspan="4">&nbsp;</td>
                <td style="background: rgb(170, 184, 231);">Grand Total</td>
                <td style="background: rgb(170, 184, 231);">{{ $grand_total }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
