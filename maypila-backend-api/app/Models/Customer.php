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
}
