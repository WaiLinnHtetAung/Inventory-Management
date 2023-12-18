<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePurchaseRequest;
use App\Http\Requests\Admin\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchases.index');
    }

    /**
     * get data with datatable
     */
    public function dataTable()
    {
        $data = Purchase::with('products', 'supplier');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->filterColumn('supplier_id', function ($query, $keyword) {
                $query->whereHas('supplier', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->editColumn('supplier_id', function ($each) {
                return $each->supplier->name;
            })
            ->editColumn('date', function ($each) {
                return Carbon::parse($each->date)->format('d-m-Y');
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('purchase_show')) {
                    $show_icon = '<a href="' . route('admin.purchases.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-3"></i></a>';
                }

                if (auth()->user()->can('purchase_edit')) {
                    $edit_icon = '<a href="' . route('admin.purchases.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-3" ></i></a>';
                }

                if (auth()->user()->can('purchase_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-3" ></i></a>';
                }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['role', 'action'])
            ->make(true);

    }

    /**
     * recent data
     */
    public function recentData()
    {
        $data = Purchase::with('products', 'supplier')->latest()->take(10);

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('supplier_id', function ($each) {
                return $each->supplier->name;
            })
            ->editColumn('date', function ($each) {
                return Carbon::parse($each->date)->format('d-m-Y');
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';

                if (auth()->user()->can('purchase_show')) {
                    $show_icon = '<a href="' . route('admin.purchases.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-3"></i></a>';
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
        $suppliers = Supplier::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $invoice_no = "# " . sprintf("%07d", Purchase::latest()->first() ? Purchase::latest()->first()->id + 1 : 1);

        return view('admin.purchases.create', compact('suppliers', 'products', 'invoice_no'));
    }

    /**
     * store new supplier
     */
    public function addSupplier(Request $request)
    {
        $supplier = Supplier::create($request->all());

        return $supplier;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create(
                [
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'supplier_id' => $request->supplier_id,
                    'grand_total' => $request->grand_total,
                ]
            );

            if ($request->rowCount && (int) $request->rowCount > 0) {
                for ($i = 1; $i <= $request->rowCount; $i++) {
                    //add qty
                    $product_id = $request->input('product_id' . $i);
                    if ($product_id) {
                        Product::where('id', $product_id)->increment('qty', $request->input('qty' . $i));

                        $purchase->products()->attach($product_id, ['qty' => $request->input('qty' . $i), 'currency' => $request->input('currency' . $i), 'price' => $request->input('price' . $i), 'total' => $request->input('total' . $i)]);

                    }
                }

            }

            DB::commit();
            return redirect()->route('admin.purchases.index')->with('success', 'Successfully Created !');
        } catch (\Exception $error) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something wrong ' . $error->getMessage()])->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase = $purchase->load('supplier', 'products');

        return view('admin.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase = $purchase->load('supplier', 'products');
        $suppliers = Supplier::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            $purchase->update(
                [
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'supplier_id' => $request->supplier_id,
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
                            $product->increment('qty', $changed_qty);
                        } elseif ($changed_qty < 0) {
                            $product->decrement('qty', abs($changed_qty));
                        }
                    }

                    $purchase->products()->updateExistingPivot($product_id, [
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
                        Product::where('id', $product_id)->increment('qty', $request->input('new_qty' . $j));

                        $purchase->products()->attach($product_id, ['qty' => $request->input('new_qty' . $j), 'currency' => $request->input('new_currency' . $j), 'price' => $request->input('new_price' . $j), 'total' => $request->input('new_total' . $j)]);

                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.purchases.index')->with('success', 'Successfully Edited !');
        } catch (\Exception $error) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something wrong ' . $error->getMessage()])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return 'success';
    }
}