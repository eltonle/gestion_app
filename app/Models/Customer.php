<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'created_by',
            'updated_by'        
    ];
}
