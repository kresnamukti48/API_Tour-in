<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Account',
            'Card',
            'Store',
            'Wallet',
        ];

        PaymentCategory::withoutEvents(function () use ($data) {
            foreach ($data as $d) {
                PaymentCategory::firstOrCreate([
                    'name' => $d,
                ]);
            }
        });
    }
}
