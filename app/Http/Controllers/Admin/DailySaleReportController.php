<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class DailySaleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('admin.sale-report.index');
    }

    public function getReport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sales = Sale::with('customer', 'products')->whereBetween('date', [$start_date, $end_date])->get();

        return view('components.sale-report', compact('start_date', 'end_date', 'sales'))->render();
    }
}
