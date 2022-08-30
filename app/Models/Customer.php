<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    
    protected $fillable = [
            'name',
            'email',
            'mobile_no',
            'address',
            'status',
            'disponible',
            'created_by',
            'updated_by'        
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
