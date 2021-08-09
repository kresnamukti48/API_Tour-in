<?php

use App\Models\OrderSouvenir;
use App\Models\OrderTicket;
use App\Models\PaymentVendor;
use Midtrans\Snap;
use Xendit\Invoice;

if (! function_exists('createPayment')) {
    function createPayment($type, $trxid, $redirectUrl = null)
    {
        $data = null;
        $description = null;
        switch ($type) {
            case 'ticket':
                $data = OrderTicket::whereTrxId($trxid)->firstOrFail();
                $description = $data->ticket->ticket_name;
                break;

            case 'souvenir':
                $data = OrderSouvenir::whereTrxId($trxid)->firstOrFail();
                $description = $data->souvenir->souvenir_name;
                break;
        }

        $channel = $data->payment_channel;
        $vendor_method = $channel->method;
        $vendor = $vendor_method->vendor;

        if ($vendor->id == PaymentVendor::VENDOR_TRIPAY) {
            // code...
        }

        if ($vendor->id == PaymentVendor::VENDOR_DUITKU) {
            // code...
        }

        if ($vendor->id == PaymentVendor::VENDOR_XENDIT) {
            $params = [
                'external_id' => $trxid,
                'payer_email' => $data->email,
                'description' => $description,
                'amount' => $data->total,
                'success_redirect_url' => $redirectUrl,
                'failure_redirect_url' => $redirectUrl,
                'payment_methods' => [$vendor_method->code],
                'currency' => 'IDR',
            ];
            try {
                $payXendit = Invoice::create($params);
                $data = collect([
                    'redirect_url' => $payXendit['invoice_url'],
                    'token' => $payXendit['id'],
                ]);

                return $data;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        if ($vendor->id == PaymentVendor::VENDOR_MIDTRANS) {
            $params = [
                'transaction_details' => [
                    'order_id' => $trxid,
                ],
                'item_details' => [
                    [
                        'id' => $data->service->code,
                        'price' => $data->total_payment,
                        'quantity' => 1,
                        'name' => $data->service->code.' - '.$data->service->name,
                    ],
                ],
                'customer_details' => [
                    'first_name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                ],
                'enabled_payments' => [
                    $vendor_method->code,
                ],
                'callbacks' => [
                    'finish' => $redirectUrl,
                ],
            ];

            try {
                $payMidtrans = Snap::createTransaction($params);
                $data = collect([
                    'redirect_url' => $payMidtrans->redirect_url,
                    'token' => $payMidtrans->token,
                ]);

                return $data;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
