<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    public function payment()
    {
        return $this->belongsTo(Payment::class,'id','invoice_id');
    }
    public function invoice_details()
    {
        return $this->hasMany(InvoiceDetail::class,'invoice_id','id');
    }
    public function payment_details()
    {
        return $this->hasMany(PaymentDetail::class,'invoice_id','id');
    }
}
