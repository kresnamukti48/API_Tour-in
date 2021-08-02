<?php

namespace Database\Seeders;

use App\Models\PaymentVendor;
use Illuminate\Database\Seeder;

class PaymentVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Tripay',
            'Duitku',
            'Xendit',
            'Midtrans',
        ];

        PaymentVendor::withoutEvents(function () use ($data) {
            foreach ($data as $d) {
                PaymentVendor::firstOrCreate([
                    'name' => $d,
                ]);
            }
        });
    }
}
