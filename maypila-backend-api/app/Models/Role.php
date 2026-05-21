<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // NOTE: in scenarios that the pivot table did not follow the larvel naming convention
    // we must explicitly tell laravel the table name
    
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'pivot.role_user');
    // }    

    // Also below is sample if it did not follow the convention for naming the columns
    // public function roles()
    // {
    // return $this->belongsToMany(
    //     User::class,
    //     'pivot.role_user',
    //     'customer_user_id',  // FK pointing to users table
    //     'customer_role_id'   // FK pointing to roles table
    // );
    // }   
}
