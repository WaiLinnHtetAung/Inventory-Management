<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sales.index');
    }

    /**
     * get data with datatable
     */
    public function dataTable()
    {
        $data = Sale::with('products', 'customer');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->filterColumn('customer_id', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->editColumn('customer_id', function ($each) {
                return $each->customer->name;
            })
            ->editColumn('date', function ($each) {
                return Carbon::parse($each->date)->format('d-m-Y');
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('sale_show')) {
                    $show_icon = '<a href="' . route('admin.sales.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-3"></i></a>';
                }

                if (auth()->user()->can('sale_edit')) {
                    $edit_icon = '<a href="' . route('admin.sales.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-3" ></i></a>';
                }

                if (auth()->user()->can('sale_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-3" ></i></a>';
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['role', 'action'])
            ->make(true);

    }

    /**
     * get recent data
     */
    public function recentData()
    {
        $data = Sale::with('products', 'customer');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('customer_id', function ($each) {
                return $each->customer->name;
            })
            ->editColumn('date', function ($each) {
                return Carbon::parse($each->date)->format('d-m-Y');
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';

                if (auth()->user()->can('sale_show')) {
                    $show_icon = '<a href="' . route('admin.sales.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-3"></i></a>';
                }

                return '<div class="action-icon text-center">' . $show_icon . '</div>';
            })
            ->rawColumns(['role', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $invoice_no = "# " . sprintf("%07d", Sale::latest()->first() ? Sale::latest()->first()->id + 1 : 1);

        return view('admin.sales.create', compact('customers', 'products', 'invoice_no'));
    }

    /**
     * store new customer
     */
    public function addCustomer(Request $request)
    {
        $customer = Customer::create($request->all());

        return $customer;
    }

    /**
     * get product stock and price
     */
    public function getProductStock(Request $request)
    {
        $stock = Product::findOrFail($request->product_id)->qty;
        $price = Product::findOrFail($request->product_id)->price;
        $currency = Product::findOrFail($request->product_id)->currency;

        return response()->json([
            'status' => true,
            'stock' => $stock,
            'price' => $price,
            'currency' => $currency,
        ]);
    }

    /**
     * compare stock
     */
    public function compareStock(Request $request)
    {
        $inputed_qty = $request->qty;
        $product_qty = Product::findOrFail($request->product_id)->qty;

        if ($inputed_qty > $product_qty) {
            return response()->json([
                'status' => 'exceed',
                'message' => "Your quantity exceed product's stock",
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Sale::create(
                [
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'customer_id' => $request->customer_id,
                    'grand_total' => $request->grand_total,
                ]
            );

            if ($request->rowCount && (int) $request->rowCount > 0) {
                for ($i = 1; $i <= $request->rowCount; $i++) {
                    //add qty
                    $product_id = $request->input('product_id' . $i);
                    if ($product_id) {
                        Product::where('id', $product_id)->decrement('qty', $request->input('qty' . $i));

                        $purchase->products()->attach($product_id, ['qty' => $request->input('qty' . $i), 'currency' => $request->input('currency' . $i), 'price' => $request->input('price' . $i), 'total' => $request->input('total' . $i)]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.sales.index')->with('success', 'Successfully Created !');
        } catch (\Exception $error) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something wrong ' . $error->getMessage()])->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale = $sale->load('customer', 'products');

        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $sale = $sale->load('customer', 'products');
        $customers = Customer::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        return view('admin.sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        DB::beginTransaction();
        try {
            $sale->update(
                [
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'customer_id' => $request->customer_id,
                    'grand_total' => $request->grand_total,
                ]
            );

            //for old row count
            if ($request->rowCount && (int) $request->rowCount > 0) {
                for ($i = 1; $i <= $request->rowCount; $i++) {
                    //add qty
                    $product_id = $request->input('product_id' . $i);
                    $new_qty = $request->input('qty' . $i);
                    $old_qty = $request->input('old_qty' . $i);

                    $product = Product::find($product_id);

                    if ($product) {
                        $changed_qty = $new_qty - $old_qty;
                        if ($changed_qty > 0) {
                            $product->decrement('qty', $changed_qty);
                        } elseif ($changed_qty < 0) {
                            $product->increment('qty', abs($changed_qty));
                        }
                    }

                    $sale->products()->updateExistingPivot($product_id, [
                        'qty' => $new_qty,
                        'currency' => $request->input('currency' . $i),
                        'price' => $request->input('price' . $i),
                        'total' => $request->input('total' . $i),
                    ]);

                }

            }

            //for new row count
            if ($request->newRowCount && (int) $request->newRowCount > 0) {
                for ($j = 1; $j <= $request->newRowCount; $j++) {
                    //add qty
                    $product_id = $request->input('new_product_id' . $j);
                    if ($product_id) {
                        Product::where('id', $product_id)->decrement('qty', $request->input('new_qty' . $j));

                        $sale->products()->attach($product_id, ['qty' => $request->input('new_qty' . $j), 'currency' => $request->input('new_currency' . $j), 'price' => $request->input('new_price' . $j), 'total' => $request->input('new_total' . $j)]);

                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.sales.index')->with('success', 'Successfully Edited !');
        } catch (\Exception $error) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something wrong ' . $error->getMessage()])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return 'success';
    }
}