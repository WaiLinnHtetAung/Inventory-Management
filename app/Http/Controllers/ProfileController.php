<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $total_user = User::count();
        $total_category = Category::count();
        $total_product = Product::count();
        $total_customer = Customer::count();
        $total_supplier = Supplier::count();
        $total_purchase = Purchase::count();
        $total_sale = Sale::count();

        return view('dashboard', compact('total_user', 'total_category', 'total_product', 'total_customer', 'total_supplier', 'total_purchase', 'total_sale'));
    }

}
