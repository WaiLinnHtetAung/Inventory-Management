<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function pdfDownload(Request $request)
    {
        $id = $request->pdf;
        $type = $request->type;

        if ($type == 'purchase') {
            $purchase = Purchase::with('supplier', 'products')->where('id', $id)->first();

            $data = [
                'invoice_no' => $purchase->invoice_no,
                'date' => Carbon::parse($purchase->date)->format('d-m-Y'),
                'supplier_name' => $purchase->supplier->name,
                'supplier_email' => $purchase->supplier->email,
                'products' => $purchase->products,
            ];

            $pdf = Pdf::loadView('admin.pdf.purchase-invoice', $data);
            return $pdf->stream('purchase-invoice.pdf');
        } elseif ($type == 'sale') {
            $sale = Sale::with('customer', 'products')->where('id', $id)->first();

            $data = [
                'invoice_no' => $sale->invoice_no,
                'date' => Carbon::parse($sale->date)->format('d-m-Y'),
                'customer_name' => $sale->customer->name,
                'customer_email' => $sale->customer->email,
                'products' => $sale->products,
            ];

            $pdf = Pdf::loadView('admin.pdf.sale-invoice', $data);
            return $pdf->stream('sale-invoice.pdf');

        }

    }
}