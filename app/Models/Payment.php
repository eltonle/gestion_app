<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'paid_status',
        'paid-amount',
        'due_amount',
        'total_amount',
        'discount_amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }
}
