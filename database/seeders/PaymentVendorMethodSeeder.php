<?php

namespace Database\Seeders;

use App\Models\PaymentVendorMethod;
use Illuminate\Database\Seeder;

class PaymentVendorMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            0 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay BCA Virtual Account',
                'code' => 'BCAVA',
                'type' => 1,
                'status' => 0,
            ],
            1 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay BRI Virtual Account',
                'code' => 'BRIVA',
                'type' => 1,
                'status' => 0,
            ],
            2 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay Maybank Virtual Account',
                'code' => 'MYBVA',
                'type' => 1,
                'status' => 0,
            ],
            3 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay Permata Virtual Account',
                'code' => 'PERMATAVA',
                'type' => 1,
                'status' => 0,
            ],
            4 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay BNI Virtual Account',
                'code' => 'BNIVA',
                'type' => 1,
                'status' => 0,
            ],
            5 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay Mandiri Virtual Account',
                'code' => 'MANDIRIVA',
                'type' => 1,
                'status' => 0,
            ],
            6 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay Sinarmas Virtual Account',
                'code' => 'SMSVA',
                'type' => 1,
                'status' => 0,
            ],
            7 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay Muamalat Virtual Account',
                'code' => 'MUAMALATVA',
                'type' => 1,
                'status' => 0,
            ],
            8 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 1,
                'name' => 'Tripay CIMB Virtual Account',
                'code' => 'CIMBVA',
                'type' => 1,
                'status' => 0,
            ],
            9 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 2,
                'name' => 'Tripay Kartu Kredit',
                'code' => 'CC',
                'type' => 1,
                'status' => 0,
            ],
            10 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 3,
                'name' => 'Tripay Alfamart',
                'code' => 'ALFAMART',
                'type' => 1,
                'status' => 0,
            ],
            11 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 3,
                'name' => 'Tripay Alfamidi',
                'code' => 'ALFAMIDI',
                'type' => 1,
                'status' => 0,
            ],
            12 => [
                'payment_vendor_id' => 1,
                'payment_category_id' => 4,
                'name' => 'Tripay QRIS',
                'code' => 'QRIS',
                'type' => 1,
                'status' => 0,
            ],
            13 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Gopay',
                'code' => 'gopay',
                'type' => 1,
                'status' => 0,
            ],
            14 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap BCA',
                'code' => 'bca_va',
                'type' => 1,
                'status' => 0,
            ],
            15 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap CC',
                'code' => 'credit_card',
                'type' => 1,
                'status' => 0,
            ],
            16 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Shopeepay',
                'code' => 'shopeepay',
                'type' => 1,
                'status' => 0,
            ],
            17 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Bank Permata',
                'code' => 'permata_va',
                'type' => 1,
                'status' => 0,
            ],
            18 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Bank BNI',
                'code' => 'bni_va',
                'type' => 1,
                'status' => 0,
            ],
            19 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Bank BRI',
                'code' => 'bri_va',
                'type' => 1,
                'status' => 0,
            ],
            20 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Echannel',
                'code' => 'echannel',
                'type' => 1,
                'status' => 0,
            ],
            21 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Other VA',
                'code' => 'other_va',
                'type' => 1,
                'status' => 0,
            ],
            22 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Danamon Online',
                'code' => 'danamon_online',
                'type' => 1,
                'status' => 0,
            ],
            23 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Mandiri Clickpay',
                'code' => 'mandiri_clickpay',
                'type' => 1,
                'status' => 0,
            ],
            24 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Cimb Clicks',
                'code' => 'cimb_clicks',
                'type' => 1,
                'status' => 0,
            ],
            25 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap BCA Klik BCA',
                'code' => 'bca_klikbca',
                'type' => 1,
                'status' => 0,
            ],
            26 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap BCA KlikPay',
                'code' => 'bca_klikpay',
                'type' => 1,
                'status' => 0,
            ],
            27 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap BRI Epay',
                'code' => 'bri_epay',
                'type' => 1,
                'status' => 0,
            ],
            28 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap XL Tunai',
                'code' => 'xl_tunai',
                'type' => 1,
                'status' => 0,
            ],
            29 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Indosat Dompetku',
                'code' => 'indosat_dompetku',
                'type' => 1,
                'status' => 0,
            ],
            30 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap KiosOn',
                'code' => 'kioson',
                'type' => 1,
                'status' => 0,
            ],
            31 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Indomaret',
                'code' => 'Indomaret',
                'type' => 1,
                'status' => 0,
            ],
            32 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap Alfamart',
                'code' => 'alfamart',
                'type' => 1,
                'status' => 0,
            ],
            33 => [
                'payment_vendor_id' => 4,
                'payment_category_id' => null,
                'name' => 'Midtrans Snap AkuLaku',
                'code' => 'akulaku',
                'type' => 1,
                'status' => 0,
            ],
            34 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 2,
                'name' => 'Duitku Credit Card',
                'code' => 'VC',
                'type' => 1,
                'status' => 0,
            ],
            35 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku BCA KlikPay',
                'code' => 'BK',
                'type' => 1,
                'status' => 0,
            ],
            36 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku BCA Virtual Account',
                'code' => 'BC',
                'type' => 1,
                'status' => 0,
            ],
            37 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku Mandiri Virtual Account',
                'code' => 'M1',
                'type' => 1,
                'status' => 0,
            ],
            38 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku Permata Bank Virtual Account',
                'code' => 'BT',
                'type' => 1,
                'status' => 0,
            ],
            39 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku ATM Bersama',
                'code' => 'A1',
                'type' => 1,
                'status' => 0,
            ],
            40 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku CIMB Niaga Virtual Account',
                'code' => 'B1',
                'type' => 1,
                'status' => 0,
            ],
            41 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku BNI Virtual Account',
                'code' => 'I1',
                'type' => 1,
                'status' => 0,
            ],
            42 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku Maybank Virtual Account',
                'code' => 'VA',
                'type' => 1,
                'status' => 0,
            ],
            43 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 3,
                'name' => 'Duitku Ritel',
                'code' => 'FT',
                'type' => 1,
                'status' => 0,
            ],
            44 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku OVO',
                'code' => 'OV',
                'type' => 1,
                'status' => 0,
            ],
            45 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku Indodana Paylater',
                'code' => 'DN',
                'type' => 1,
                'status' => 0,
            ],
            46 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku Shopee Pay',
                'code' => 'SP',
                'type' => 1,
                'status' => 0,
            ],
            47 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku Shopee Pay Apps',
                'code' => 'SA',
                'type' => 1,
                'status' => 0,
            ],
            48 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku Bank Artha Graha',
                'code' => 'AG',
                'type' => 1,
                'status' => 0,
            ],
            49 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 1,
                'name' => 'Duitku Bank Sahabat Sampoerna',
                'code' => 'S1',
                'type' => 1,
                'status' => 0,
            ],
            50 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku LinkAja Apps (Percentage Fee)',
                'code' => 'LA',
                'type' => 1,
                'status' => 0,
            ],
            51 => [
                'payment_vendor_id' => 2,
                'payment_category_id' => 4,
                'name' => 'Duitku LinkAja Apps (Fixed Fee)',
                'code' => 'LF',
                'type' => 1,
                'status' => 0,
            ],
            52 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 1,
                'name' => 'Xendit BCA virtual account',
                'code' => 'BCA',
                'type' => 1,
                'status' => 0,
            ],
            53 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 1,
                'name' => 'Xendit BRI virtual account',
                'code' => 'BRI',
                'type' => 1,
                'status' => 0,
            ],
            54 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 1,
                'name' => 'Xendit BNI virtual account',
                'code' => 'BNI',
                'type' => 1,
                'status' => 0,
            ],
            55 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 1,
                'name' => 'Xendit Mandiri virtual account',
                'code' => 'MANDIRI',
                'type' => 1,
                'status' => 0,
            ],
            56 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 1,
                'name' => 'Xendit Permata virtual account',
                'code' => 'PERMATA',
                'type' => 1,
                'status' => 0,
            ],
            57 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 3,
                'name' => 'Xendit Alfamart retail outlet',
                'code' => 'ALFAMART',
                'type' => 1,
                'status' => 0,
            ],
            58 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 3,
                'name' => 'Xendit Indomaret retail outlet',
                'code' => 'INDOMARET',
                'type' => 1,
                'status' => 0,
            ],
            59 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 4,
                'name' => 'Xendit OVO e-wallet',
                'code' => 'OVO',
                'type' => 1,
                'status' => 0,
            ],
            60 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 4,
                'name' => 'Xendit DANA e-wallet',
                'code' => 'DANA',
                'type' => 1,
                'status' => 0,
            ],
            61 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 4,
                'name' => 'Xendit LinkAja e-wallet',
                'code' => 'LINKAJA',
                'type' => 1,
                'status' => 0,
            ],
            62 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 2,
                'name' => 'Xendit Visa credit and debit cards',
                'code' => 'VISA',
                'type' => 1,
                'status' => 0,
            ],
            63 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 2,
                'name' => 'Xendit Mastercard credit and debit cards',
                'code' => 'MASTERCARD',
                'type' => 1,
                'status' => 0,
            ],
            64 => [
                'payment_vendor_id' => 3,
                'payment_category_id' => 2,
                'name' => 'Xendit JCB credit and debit cards',
                'code' => 'JCB',
                'type' => 1,
                'status' => 0,
            ],
        ];

        PaymentVendorMethod::withoutEvents(function () use ($data) {
            foreach ($data as $d) {
                PaymentVendorMethod::firstOrCreate($d);
            }
        });
    }
}
