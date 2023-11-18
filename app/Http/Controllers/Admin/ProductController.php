<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * get data with dataTable
     */
    public function dataTable()
    {
        $data = Product::with('category');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->filterColumn('category_id', function ($query, $keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('photo', function ($each) {
                $url = $each->imgUrl();
                return "<img src='$url' width='120' height='120' />";
            })
            ->editColumn('category_id', function ($each) {
                return $each->category->name;
            })
            ->editColumn('price', function ($each) {
                return "<span class='text-primary fw-bold'>$each->currency</span> " . number_format($each->price);
            })
            ->editColumn('qty', function ($each) {
                return "<span class='p-3 bg-info text-white rounded fw-bold'>$each->qty</span>";
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('product_edit')) {
                    $edit_icon = '<a href="' . route('admin.products.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-2" ></i></a>';
                }

                if (auth()->user()->can('product_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-2" ></i></a>';
                }

                return '<div class="action-icon">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['photo', 'price', 'qty', 'action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        if ($request->file('photo')) {
            $fileName = uniqid() . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/images', $fileName);

            $product->update(['photo' => $fileName]);
        }
        return redirect()->route('admin.products.index')->with('success', 'Successfully Created !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::pluck('name', 'id');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $oldPhoto = $product->photo;
        $product->update($request->all());

        if ($request->file('photo')) {
            if ($oldPhoto) {
                Storage::disk('public')->delete('images/' . $oldPhoto);
            }

            $newPhoto = uniqid() . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/images', $newPhoto);
            $product->update(['photo' => $newPhoto]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Successfully Edited !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $photoName = $product->photo;
        if ($photoName) {
            Storage::disk('public')->delete('images/' . $photoName);
        }

        $product->delete();

        return 'success';
    }
}
