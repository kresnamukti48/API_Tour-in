<?php

namespace App\Http\Controllers;

use App\Models\PaymentCategory;
use App\Models\PaymentVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Log;
use Notification;
use Xendit\Invoice;

class StatusController extends Controller
{
    protected $vendor;
    protected $category;

    public function __construct()
    {
        $this->vendor = new PaymentVendor();
        $this->category = new PaymentCategory();
    }

    public function status($trxid)
    {
        try {
            $order_finder = order_finder($trxid);
            $order_model = new $order_finder['model']();
            $order = $order_finder['data'];

            $payment_channel = $order->payment_channel;
            $payment_method = $payment_channel->method;
            $payment_category = $payment_method->category;
            $payment_vendor = $payment_method->vendor;

            if ($order_finder['type'] == 'ticket') {
                switch ($payment_vendor->id) {
                    case $this->vendor::VENDOR_XENDIT:
                        $payment = new Collection();

                        $payment_data = Invoice::retrieve($order->merchant_ref);

                        $payment->put('account_name', $payment_method->code);
                        $payment->put('account_type', $payment_category->name);

                        switch ($payment_category->id) {
                            case $this->category::CATEGORY_VA:
                                $payment->put('account_number', $payment_data['available_banks'][0]['bank_account_number']);
                                break;

                            case $this->category::CATEGORY_STORE:
                                $payment->put('account_number', $payment_data['available_retail_outlets'][0]['payment_code']);
                                break;
                        }

                        $payment->put('amount', $order->total);
                        $payment->put('invoice_url', $payment_data['invoice_url']);

                        $order->payment = $payment;
                        break;
                }

                return responder()->success($order->withoutRelations());
            }
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());

            return responder()->error(null, 'Terjadi kesalahan pada sistem. Silahkan ulangi beberapa saat lagi');
        }
    }

    public function callback(Request $request, $vendor, $merchat_ref = null)
    {
        switch ($vendor) {
            case 'midtrans':
                return $this->callback_midtrans();
                break;

            case 'xendit':
                return $this->callback_xendit($request->all());
                break;

            default:
                // code...
                break;
        }
    }

    public function callback_midtrans()
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;

        $order_finder = order_finder($notif->order_id);
        $order_model = new $order_finder['model']();
        $order = $order_finder['data'];

        if ($transaction == 'settlement') {
            if ($order_finder['type'] == 'ticket') {
                $order->update([
                    'status' => $order_model::STATUS_PROCESS,
                ]);

                return responder()->success($order);
            }
        } elseif (in_array($transaction, ['cancel', 'expire', 'failure'])) {
            if ($order_finder['type'] == 'ticket') {
                $order->update([
                    'status' => $order_model::STATUS_EXPIRED,
                ]);

                return responder()->success($order);
            }
        }
    }

    public function callback_xendit($notif)
    {
        $merchant_ref = $notif['id'];
        $status = $notif['status'];

        $order_finder = order_finder($notif['external_id'], $merchant_ref);
        $order_model = new $order_finder['model']();
        $order = $order_finder['data'];

        if ($status === 'PAID') {
            if ($order_finder['type'] == 'ticket') {
                $order->update([
                    'status' => $order_model::STATUS_PROCESS,
                ]);

                return responder()->success($order);
            }
        } elseif ($status === 'EXPIRED') {
            if ($order_finder['type'] == 'ticket') {
                $order->update([
                    'status' => $order_model::STATUS_EXPIRED,
                ]);

                return responder()->success($order);
            }
        }
    }
}
