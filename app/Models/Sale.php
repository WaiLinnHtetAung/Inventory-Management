<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 'customer_id', 'date', 'grand_total'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'currency', 'price', 'total');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
