<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Enum\CustomerStatus;

class Customer extends Model
{
    public function queueSession()
    {
        return $this->belongsTo(QueueSession::class);
    }
    public function status()
    {
        return $this->belongsTo(
            CustomerStatus::class,
            'customer_status', // foreign key in customers table
            'value'            // referenced column in lookup.customer_status
        );
    }    
}
