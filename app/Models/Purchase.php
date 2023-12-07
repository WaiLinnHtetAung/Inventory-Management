<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 'date', 'supplier_id', 'grand_total'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'currency', 'price', 'total');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
