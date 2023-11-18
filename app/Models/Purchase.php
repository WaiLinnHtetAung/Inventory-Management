<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 'date'];

    public function suppliers() {
        return $this->belongsToMany(Supplier::class);
    }
}
