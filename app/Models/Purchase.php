<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'unit_id',
        'category_id',
        'product_id',
        'purchase_no',
        'date',
        'buying_qty',
        'unit_price',
        'buying_price',
        'created_by',
        'updated_by',
        'description'
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
