<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DailyPurchaseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchase-report.index');
    }

    public function getReport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $purchases = Purchase::with('supplier', 'products')->whereBetween('date', [$start_date, $end_date])->get();

        return view('components.purchase-report', compact('start_date', 'end_date', 'purchases'))->render();
    }

}
