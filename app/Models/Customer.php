<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'dob',
        'email'
    ];
    protected $casts = [
        'dob' => 'date',
        'creation_date' => 'datetime'
    ];
}
