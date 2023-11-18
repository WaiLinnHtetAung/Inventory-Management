<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'currency', 'price', 'qty', 'photo'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function imgUrl()
    {
        if ($this->photo) {
            return asset('storage/images/' . $this->photo);
        } else {
            return asset('default.png');
        }
    }

}
