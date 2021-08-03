<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;

class StatusController extends Controller
{
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
