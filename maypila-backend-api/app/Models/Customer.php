<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Enum\CustomerStatus;

/**
 * @property int $id
 * @property int $queue_session_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property \Illuminate\Support\Carbon|null $accepted_on
 * @property \Illuminate\Support\Carbon|null $ended_on
 * @property int $que_number
 * @property string $customer_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'queue_session_id',
        'first_name',
        'last_name',
        'mobile_number',
        'customer_status',
        'que_number',
    ];

    public function queueSession()
    {
        return $this->belongsTo(QueueSession::class);
    }
}
