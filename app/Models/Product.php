<?php

namespace App\Models;

use App\Models\Category;
use App\Models\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'status',     
        'created_by',
        'updated_by',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function invoice_details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

   
}
