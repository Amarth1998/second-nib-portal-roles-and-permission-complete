<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Model
{
    use HasApiTokens;
    // Define the table name if it differs from the plural of the model name
    protected $table = 'customers';

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'customer_name',
        'state',
        'number',
    ];

    // If you want to hide sensitive data (optional), you can use the $hidden property
    protected $hidden = [
        // Example: 'password' (if applicable)
    ];

    // If the column names are not the default timestamp names ('created_at' and 'updated_at')
    // you can define custom column names for the timestamp columns
    // protected $created_at = 'created_on';
    // protected $updated_at = 'updated_on';

    // Additional relationships or methods can be added here if necessary
}
