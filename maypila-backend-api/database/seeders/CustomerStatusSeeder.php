<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CustomerStatus;

class CustomerStatusSeeder extends Seeder
{

    // To run this seeder individually, use:
    // php artisan db:seed --class=CustomerStatusSeeder
    public function run(): void
    {
        $customer_status = [
            'Pending',
            'InProgress',
            'Done'
        ];

        foreach ($customer_status as $index => $status) {
            CustomerStatus::firstOrCreate([
                'name' => $status,
                'value' => $index
            ]);
        }
    }
}
